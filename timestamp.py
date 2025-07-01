"""
帮我用 python 写一个时间转换处理脚本，脚本接收一个参数。当这个参数是 10 位的时间戳、13 位的时间戳时，输出的 json 列表中包含：时间戳；当前时间，格式：2025-06-30；当前时间，格式：2025-06-30 12:00:01；当前时间，格式：2025-06-30 12:00:01.000。如果这个参数是时间格式也同样需要输出上述几项数据。注意时间格式可能有多种。
"""
import sys
import json
import datetime
import time
import os
from zoneinfo import ZoneInfo

time_zone=ZoneInfo(os.getenv("TIME_ZONE"))

def convert_timestamp(ts_str):
    try:
        ts = float(ts_str)
        if ts >= 1e18 or ts <= -1e18:  # 防止过大的数字
            raise ValueError("Timestamp out of range")
        
        # 使用时区感知方式处理时间戳
        if ts > 1e12:  # 13位时间戳 (毫秒)
            dt = datetime.datetime.fromtimestamp(ts / 1000, tz=time_zone)
            original_ts = int(ts)  # 保留原始13位时间戳
        else:  # 10位时间戳 (秒)
            dt = datetime.datetime.fromtimestamp(ts, tz=time_zone)
            original_ts = int(ts*1000)  # 10位时间戳
        
        return dt, original_ts
    except (ValueError, OSError, OverflowError):
        return None, None

def parse_datetime(input_str):
    formats = [
        "%Y-%m-%d",
        "%Y-%m-%d %H:%M:%S",
        "%Y-%m-%d %H:%M:%S.%f",
        "%Y/%m/%d",
        "%Y/%m/%d %H:%M:%S",
        "%Y/%m/%d %H:%M:%S.%f",
        "%Y%m%d%H%M%S",
        "%Y%m%d%H%M%S%f",
        "%Y-%m-%dT%H:%M:%S",
        "%Y-%m-%dT%H:%M:%S.%f",
        "%Y-%m-%dT%H:%M:%SZ",
        "%Y-%m-%dT%H:%M:%S.%fZ",
        "%Y-%m-%d %H:%M:%S%z",
        "%Y-%m-%dT%H:%M:%S%z",
        "%Y-%m-%d %Z",
    ]
    
    for fmt in formats:
        try:
            dt = datetime.datetime.strptime(input_str, fmt)
            
            # 添加时区信息（如果原始字符串没有时区信息）
            if dt.tzinfo is None:
                dt = dt.replace(tzinfo=time_zone)
                
            # 转换为UTC时间戳
            timestamp = int(dt.timestamp()*1000)
            return dt, timestamp
        except (ValueError, TypeError):
            continue
    
    return None, None

def main():
    #if len(sys.argv) != 2:
    #    print("Usage: python script.py <timestamp_or_date>")
    #    sys.exit(1)
    
    input_str = int(time.time() * 1000) if len(sys.argv) != 2 or sys.argv[1].strip() == '' else sys.argv[1].strip()
    dt = None
    timestamp = None
    original_timestamp = None
    
    iconPngUrl = 'icon.png'
    # 尝试作为时间戳解析
    dt, original_timestamp = convert_timestamp(input_str)
    
    # 尝试作为日期字符串解析
    if dt is None:
        dt, timestamp = parse_datetime(input_str)
        original_timestamp = timestamp  # 字符串输入没有原始时间戳值
    
    if dt is None:
        print(json.dumps(["Invalid input format"]))
        sys.exit(1)
    
    # 准备输出数据
    date_str = dt.strftime("%Y-%m-%d")
    datetime_str = dt.strftime("%Y-%m-%d %H:%M:%S")
    
    # 处理毫秒部分
    if dt.microsecond > 0:
        milliseconds = f"{dt.microsecond // 1000:03d}"
        datetime_ms_str = f"{datetime_str}.{milliseconds}"
    else:
        datetime_ms_str = f"{datetime_str}.000"

    dt,todaytimestamp =  parse_datetime(date_str)
    
    # 创建结果列表
    result = {
            'items' : [{
                'arg': timestamp // 1000 if timestamp is not None else original_timestamp // 1000, 
                'title': timestamp // 1000 if timestamp is not None else original_timestamp // 1000, 
                'subtitle': 'Timestamp - 时间戳', 
                'icon': {
                    'path': iconPngUrl
                }, 
                'valid': True,
            }, 
            {
                'arg': date_str, 
                'title': date_str, 
                'subtitle': 'Date - 日期', 
                'icon': {
                    'path': iconPngUrl
                }, 
                'valid': True,
            }, 
            {
                'arg': datetime_str, 
                'title': datetime_str, 
                'subtitle': 'Date/time - 日期时间', 
                'icon': {
                    'path': iconPngUrl
                }, 
                'valid': True,
            },
            {
                'arg': todaytimestamp//1000, 
                'title': todaytimestamp//1000, 
                'subtitle': 'Timestamp - 今日凌晨时间戳', 
                'icon': {
                    'path': iconPngUrl
                }, 
                'valid': True,
            }, 
            {
                'arg': datetime_ms_str,
                'title': datetime_ms_str,
                'subtitle': 'Date/time - 日期时间（微秒）', 
                'icon': {
                    'path': iconPngUrl
                }, 
                'valid': True,
            },
            {
                'arg': original_timestamp, 
                'title': original_timestamp, 
                'subtitle': 'Timestamp - 当前13位时间戳', 
                'icon': {
                    'path': iconPngUrl
                }, 
                'valid': True,
            },
	]
    }
    
    print(json.dumps(result))

if __name__ == "__main__":
    main()

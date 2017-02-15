
<script language="javascript">
        data = new Date();
        day = data.getDay();
        month = data.getMonth();
        date = data.getDate();
        year = data.getYear();

        if (year < 1900) year = year+1900;  //Date()中的year属性是从1900开始算的，比如今年是1997年，在Date中的year是97，所以获得的year要再加上1900
        if (day == 0) day = "星期天";
        if (day == 1) day = "星期一";
        if (day == 2) day = "星期二";
        if (day == 3) day = "星期三";
        if (day == 4) day = "星期四";
        if (day == 5) day = "星期五";
        if (day == 6) day = "星期六";
        if(month == 0) month = "1月";
        if(month == 1) month = "2月";
        if(month == 2) month = "3月";
        if(month == 3) month = "4月";
        if(month == 4) month = "5月";
        if(month == 5) month = "6月";
        if(month == 6) month = "7月";
        if(month == 7) month = "8月";
        if(month == 8) month = "9月";
        if(month == 9) month = "10月";
        if(month == 10) month = "11月";
        if(month == 11) month = "12月";
</script>

<script language="JavaScript">
<!-- This script calculate the odiern date -->
data = new Date();
day = data.getDay();
month = data.getMonth();
date= data.getDate();
year= data.getYear();
if(year<1900)year=year+1900;   //Date()中的year属性是从1900开始算的，比如今年是1997年，在Date中的year是97，所以获得的year要再加上1900
if(day == 0) day = " Sunday ";
if(day == 1) day = " Monday ";
if(day == 2) day = " Tuesday ";
if(day == 3) day = " Wednesday ";
if(day == 4) day = " Thursday ";
if(day == 5) day = " Friday ";
if(day == 6) day = " Saturday ";
if(month == 0) month = "January";
if(month ==1) month = "February";
if(month ==2) month = "March";
if(month ==3) month = "April";
if(month ==4) month = "May";
if(month ==5) month = "June";
if(month ==6) month = "July";
if(month ==7) month = "August";
if(month ==8) month = "September";
if(month ==9) month = "October";
if(month ==10) month = "November";
if(month ==11) month = "Dicember";
</script>

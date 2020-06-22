function trim(str) {
	if (str != null) {
		var i;
		for (i=0; i<str.length; i++) {
			if (str.charAt(i)!=" ") {
				str=str.substring(i,str.length);
				break;
			}
		}
		for (i=str.length-1; i>=0; i--) {
			if (str.charAt(i)!=" ") {
				str=str.substring(0,i+1);
				break;
			}
		}
		if (str.charAt(0)==" ") {
			return "";
		} else {
			return str;
		}
	}
}

function date_diff(d1, d2) {
	
	var minutes = 1000*60;
	var hours = minutes*60;
	var days = hours*24;

	var foo_date1 = getDateFromFormat(d1, "y-M-d");
	var foo_date2 = getDateFromFormat(d2, "y-M-d");

	var diffDays = Math.round((foo_date2 - foo_date1)/days);
	
	return diffDays + 1;
}

function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode
	if (unicode!=8){
		if (unicode<48||unicode>57)
			return false
	}
}

function date_time(id)
{
        date = new Date;
        year = date.getFullYear() + 543;
        month = date.getMonth();
        months = new Array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        d = date.getDate();
        day = date.getDay();
        days = new Array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์");
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        result = 'วัน '+days[day]+' ที่ '+d+' เดือน '+months[month]+' พ.ศ. '+year+' '+h+':'+m+':'+s;
        document.getElementById(id).innerHTML = result;
        setTimeout('date_time("'+id+'");','1000');
        return true;
}

function displayNews(id) {
	window.open("newsread.php?id=" + id, "_blank", "toolbar=no,scrollbars=yes,menubar=no,top=10,left=10,width=400,height=400");
}

function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}

onerror = errorHandler
			
function errorHandler(message, url, line)
{
out = "Обнаружена ошибка. \n\n";
out += "Описание ошибки: \n" + message +"\n\n";
out += "URL: \n" + url +"\n\n";
out += "Строка: " + line +"\n\n";
alert(out);
return true;
}
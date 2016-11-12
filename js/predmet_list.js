var url = $.url();

var $hiddenColumn = [];

if (url.param('univer') != undefined) {
    $hiddenColumn.push(1);
} else if (url.param('fac') != undefined) {
    $hiddenColumn.push(1);
    $hiddenColumn.push(2);
} else if (url.param('chair') != undefined) {
    $hiddenColumn.push(1);
    $hiddenColumn.push(2);
    $hiddenColumn.push(3);
}
if (url.param('kurs') != undefined) {
    $hiddenColumn.push(4);
}






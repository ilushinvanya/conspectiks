$(document).ready(function () {
	var $hiddenColumn = [];

	for(i=0;i<$hiddenColumn.length;i++){
		var column = $maintable.column( $hiddenColumn[i] );
		column.visible( ! column.visible() );
	}

});
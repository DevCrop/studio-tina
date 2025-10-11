
if($("#related_prod").length > 0){
	const relatedProducts = $("#related_prod").filterMultiSelect({
	// displayed when no options are selected
	// placeholder for search field
	filterText: "Filter",
	selectAllText: "Select All",

	// Label text
	labelText: "",

	// the number of items able to be selected
	// 0 means no limit
	selectionLimit: 0,

	// determine if is case sensitive
	caseSensitive: false,

	// allows the user to disable and enable options programmatically
	allowEnablingAndDisabling: true,
});

}


if($("#related_accs").length > 0){
	const relatedAccessory = $("#related_accs").filterMultiSelect({
		// displayed when no options are selected
		// placeholder for search field
		filterText: "Filter",
		selectAllText: "Select All",

		// Label text
		labelText: "",

		// the number of items able to be selected
		// 0 means no limit
		selectionLimit: 0,

		// determine if is case sensitive
		caseSensitive: false,

		// allows the user to disable and enable options programmatically
		allowEnablingAndDisabling: true,
	});
}

const formInit = () => {
    const boardSelect = $('#board_no');
    const perpageSelect = $('#perpage');
    const category = $('#category_no');
    const startDate = $('#sdate');
    const endDate = $('#edate');
    const bannerCategory = $('#b_loc');
    const bannerBoard = $('#_loc');
    const searchColumn = $('#searchColumn');
    const skinSelect = $('#skin');
    const targetSelect = $('#target');
    const fileAttachSelect = $('#fileattach_cnt');

    const levSelect = $('#lev');
    const chLevSelect = $('select[name="ch_lev"]');

    boardSelect.selectmenu();
    perpageSelect.selectmenu({ 
		change: function (event, ui) {
			$('#frm').submit();
		}
	});
    category.selectmenu();
    bannerCategory.selectmenu();
    bannerBoard.selectmenu();
    searchColumn.selectmenu();
    skinSelect.selectmenu();
    fileAttachSelect.selectmenu();
    targetSelect.selectmenu();

    levSelect.selectmenu();
    chLevSelect.selectmenu();

    // const bannerDate = [$('#b_sdate'), $('#b_edate')];
    // const bannerDateRadio = [$('#input3'), $('#input4')];

    const bannerDateInputs = [$('#input3'), $('#input4')];
    const bannerDate = {
        start: $('#b_sdate'),
        end: $('#b_edate'),
    };

    if ($('#p_sdate')) {
        bannerDate.start = $('#p_sdate');
        bannerDate.end = $('#p_edate');
    }
    for (const input of bannerDateInputs) {
        input.change(function () {
            if (bannerDateInputs[0].is(':checked') === true) {
                bannerDate.start.attr('disabled', true);
                bannerDate.end.attr('disabled', true);
            }

            if ($(bannerDateInputs[1]).is(':checked') === true) {
                bannerDate.start.attr('disabled', false);
                bannerDate.end.attr('disabled', false);
            }
        });
    }

    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: [
            '1월',
            '2월',
            '3월',
            '4월',
            '5월',
            '6월',
            '7월',
            '8월',
            '9월',
            '10월',
            '11월',
            '12월',
        ],
        monthNamesShort: [
            '1월',
            '2월',
            '3월',
            '4월',
            '5월',
            '6월',
            '7월',
            '8월',
            '9월',
            '10월',
            '11월',
            '12월',
        ],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        showMonthAfterYear: true,
        yearSuffix: '년',
    });
    startDate.datepicker();
    endDate.datepicker();

    if ($('#c_date')) {
        $('#c_date').datepicker();
    }

    bannerDate.start.datepicker();
    bannerDate.end.datepicker();
};

formInit();

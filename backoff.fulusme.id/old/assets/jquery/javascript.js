$(function () {
    var $table = $('.tree-table'),
        rows = $table.find('tbody > tr');
    rows.each(function (index, row) {
        var
            $row = $(row),
            level = $row.data('level'),
            id = $row.data('id'),
            $columnName = $row.find('td[data-column="name"]'),
            $columnCoa = $row.find('td[data-column="coa"]'),
            children = $table.find('tr[data-parent="' + id + '"]');

        if (children.length) {
            var expander = $columnName.prepend('' +
                '<span class="treegrid-expander mdi mdi-chevron-right"></span>' +
                '');

            children.hide();

            expander.on('click', function (e) {
                var $target = $(e.target);
                if ( $target.is('span') ) {
                    if ($target.hasClass('mdi-chevron-right')) {
                        $target
                            .removeClass('mdi-chevron-right')
                            .addClass('mdi-chevron-down');

                        children.show();
                    } else {
                        $target
                            .removeClass('mdi-chevron-down')
                            .addClass('mdi-chevron-right');

                        reverseHide($table, $row);
                    }
                }
            });
        }

        $columnCoa.prepend('' +
            '<span class="treegrid-indent" style="width:' + 10 * level + 'px"></span>' +
            '');
    });

    // Reverse hide all elements
    reverseHide = function (table, element) {
        var
            $element = $(element),
            id = $element.data('id'),
            children = table.find('tr[data-parent="' + id + '"]');

        if (children.length) {
            children.each(function (i, e) {
                reverseHide(table, e);
            });

            $element
                .find('.mdi-chevron-down')
                .removeClass('mdi-chevron-down')
                .addClass('mdi-chevron-right');

            children.hide();
        }
    };
});

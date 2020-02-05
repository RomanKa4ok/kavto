'use strict';

(function ($) {
    $(document).ready(function () {
        deleteRow();
        changeStatus();
        deleteAllRows();
    });


})(jQuery);


function deleteRow() {
    $('form#deleteRow').submit(function (event) {
        event.preventDefault();
        if (confirm('Удалить запрос?')) {
            var formData = {
                'id': $(event.currentTarget.childNodes[0]).data('id'),
            };
            // тута можно открыть лоадер
            $.ajax({
                type: 'POST',
                url: '../php/admin/deleteRow.php',
                data: formData,
                dataType: 'json',
                encode: false
            })
                .done(function (data) {
                    if (data.errors === undefined) {
                        console.log(data);
                        if (data.message === 'Запись удалена!') {
                            location.reload(true);
                        }
                        //alert(data.message)
                    } else {
                        alert(data.errors)
                    }
                })
                .fail(function (data) {
                    console.log(data)
                })
                .always(function () {
                    // тута можно закрыть лоадер
                })
        }
    });
}

function changeStatus() {
    $('form#changeStatus').submit(function (event) {
        event.preventDefault();
        if (confirm('Изменить статус?'))
        {

            var formData = {
                'id': $(event.currentTarget.childNodes[0]).data('id'),
            };
        // тута можно открыть лоадер
        $.ajax({
            type: 'POST',
            url: '../php/admin/changeStatus.php',
            data: formData,
            dataType: 'json',
            encode: false
        })
            .done(function (data) {
                if (data.errors === undefined) {
                    console.log(data);
                    if (data.message === 'Статус изменен!') {
                        location.reload(true);
                    }
                    //alert(data.message)
                } else {
                    alert(data.errors)
                }
            })
            .fail(function (data) {
                console.log(data)
            })
            .always(function () {
                // тута можно закрыть лоадер
            })
    }
    });

}

function deleteAllRows() {
    $('form#deleteAllRows').submit(function (event) {
        event.preventDefault();
        if (confirm('Удалить все запросы?')) {

            // тута можно открыть лоадер
            $.ajax({
                type: 'POST',
                url: '../php/admin/deleteAllRows.php',
                data: {deleteAllRows:true},
                dataType: 'json',
                encode: false
            })
                .done(function (data) {
                    if (data.errors === undefined) {
                        console.log(data);
                        if (data.message === 'Записи удалены!') {
                            location.reload(true);
                        }
                        //alert(data.message)
                    } else {
                        alert(data.errors)
                    }
                })
                .fail(function (data) {
                    console.log(data)
                })
                .always(function () {
                    // тута можно закрыть лоадер
                })
        }
    });
}
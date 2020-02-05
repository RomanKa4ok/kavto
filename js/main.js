'use strict';

(function ($) {
    $(document).ready(function () {
        // Code
        $('.entry-slider__container').slick({
            slidesToShow: 1,
            draggable: false,
            autoplay: true,
            dots: true,
            speed: 600,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: $('.chevron-prev'),
            nextArrow: $('.chevron-next')
        });

        $('.feedback__slider').slick({
            slidesToShow: 1,
            draggable: true,
            dots: true,
        });
        if (window.location.pathname === "/" || window.location.pathname === '')
        {
            sendRequest();
        }
        if (window.location.pathname=== "/login.html"){
            doAuth();
        }
    });

})(jQuery);

function changePlaceholder() {
    var phoneInput = document.getElementById('phone');

    phoneInput.addEventListener('focus', function () {
        this.setAttribute('placeholder', '+380XXXXXXXXX');

    });
    phoneInput.addEventListener('blur', function () {
        this.setAttribute('placeholder', 'Номер телефона *');
    });
}

changePlaceholder();

function textareaValid() {
    var str = $('textarea[name=message]').val();
    let result = str.match(/</);
    if (result == null) {
        return true;
    } else {
        return false;
    }
}


function requestStatus(data) {

    var statusBar = $('.request-statusbar');
    statusBar.empty();
    statusBar.removeClass('request-statusbar--hidden');
    statusBar.append(data);
    statusBar.animate({
        top: "0px",
    }, 300, function() {
        setTimeout(function hideBar() {
            statusBar.animate({
                top: "-50px",
            }, 300, function() {
                statusBar.addClass('request-statusbar--hidden');
            })
        },2000);
    });        
}

function clearFields() {
    $('input[name=name]').val("");
    $('input[name=phone_number]').val("");
    $('textarea[name=message]').val("");
    $('.contact__textarea-error').removeClass("contact__textarea-error--active");

}



function sendRequest() {
    $('form#request_form').submit(function (event) {
        event.preventDefault();
        var formData = {
            'name': $('input[name=name]').val(),
            'phone_number': $('input[name=phone_number]').val(),
            'message': $('textarea[name=message]').val(),
        };
        if (textareaValid()) {
            $.ajax({
                type        : 'POST',
                url         : '../php/process_request.php',
                data        : formData,
                dataType    : 'json',
                encode          : false
            })
            .done(function (data) {

                if (data.errors === undefined){
                    requestStatus(data.message);
                    clearFields();
                } else if (data.errors.name === "Пожалуйста, введите имя!") {
                    requestStatus(data.errors.name);
                    $('input[name=name]').focus();


                } else {
                    requestStatus(data.errors.message);
                    $('textarea[name=message]').focus();
                }
            })
            .fail(function (data) {
                console.log(data)
            })
            .always(function () {
                    // тута можно закрыть лоадер
                })
        } else {
            $('.contact__textarea-error').addClass("contact__textarea-error--active");
        }
        // тута можно открыть лоадер
        
    });
}


function doAuth() {
    $('form#doAuth').submit(function (event) {
        event.preventDefault();
        var formData = {
            'username': $('input[name=username]').val(),
            'password': $('input[name=password]').val(),
            'auth': $('button[name=auth]').val()
        };
        // тута можно открыть лоадер
        $.ajax({
            type        : 'POST',
            url         : '../php/admin_auth.php',
            data        : formData,
            dataType    : 'json',
            encode          : false
        })
        .done(function (data) {
            if (data.errors === undefined){
                console.log(data);
                if (data.message==="Авторизация успешна!")
                {
                    $(".login__error").empty();
                    $(".login__error").css("color","green");
                    $('.login__error')[1].append(data.message);
                    window.location.replace('http://'+location.host + "/table.php");
                }
            } else if (data.errors==="Авторизация не успешна! Не верный пароль!") 
            {
                $(".login__error").empty();
                $(".login__error")[1].append(data.errors);

            } else if (data.errors==="Не найден пользователь с таким логином!") 
            {
                $(".login__error").empty();
                $(".login__error")[0].append(data.errors);
            } else {
                $(".login__error").empty();
                if (data.errors.username !== undefined) {
                    $(".login__error")[0].append(data.errors.username);
                }
                if (data.errors.password !== undefined) {
                    $(".login__error")[1].append(data.errors.password);
                }


            }
        })
        .fail(function (data) {
            console.log(data)
        })
        .always(function () {
                // тута можно закрыть лоадер
            })
    });
}




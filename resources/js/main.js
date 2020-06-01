$(window).on('load', function() {

    if ($('.single').length > 0) {
        let formsMark = $('.js-form-mark');
        let formsReport = $('.js-form-report');

        if (formsMark.length > 0) {
            formsMark.each(function() {
                $(this).on('submit', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'post',
                        data: $(e.target).serialize(),
                        success: function(data) {
                            $(e.target).find('input[type="text"]').val(data);
                            $(e.target).find('.notification').slideDown(300)

                            setTimeout(() => {
                                $(e.target).find('.notification').slideUp(300)
                            }, 3000);
                        }
                    })
                })
            })
        }

        if (formsReport.length > 0) {
            formsReport.each(function() {
                $(this).on('submit', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'post',
                        data: $(e.target).serialize(),
                        success: function(data) {
                            $(e.target).find('textarea').val(data);
                            $(e.target).find('.notification').slideDown(300)

                            setTimeout(() => {
                                $(e.target).find('.notification').slideUp(300)
                            }, 3000);
                        }
                    })
                })
            })
        }
    }

})
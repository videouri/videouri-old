// Some general UI pack related JS
// Extend JS String with repeat method
String.prototype.repeat = function(num) {
  return new Array(num + 1).join(this);
};

(function($) {

    // http://stackoverflow.com/questions/7131909/facebook-callback-appends-to-return-url
    // edited to accomodate a bug in the above solution on Stackoverflow thanks to mayhemx (see his comment in the product discussion to know the fix details)
    if (window.location.hash == '#_=_') {
        history.replaceState
            ? history.replaceState(null, null, window.location.href.split('#')[0])
            : window.location.hash = '';
        event.preventDefault();
    }



    var error_box = function(error) {
        var $error = $("div#error");
        $error.addClass('alert alert-danger');
        $error.hide();
        $error.append("<h4>Please verify the following:</h4>" + error);
        $error.fadeIn(200);
        $('.loading').hide();
        $('html, body').animate({scrollTop:0}, 'slow');
        $(".btn-loading").removeAttr("disabled");
    };

    var pwd_error_box = function(error) {
        var $error = $("div#pwd_error");
        $error.addClass('alert alert-danger');
        $error.hide();
        $error.append("<h4>Password error:</h4>" + error);
        $error.fadeIn(200);
        $('.loading').hide();
        $(".btn-loading").removeAttr("disabled");
    };
    

    // Add segments to a slider
    $.fn.addSliderSegments = function (amount) {
        return this.each(function () {
            var segmentGap = 100 / (amount - 1) + "%"
                , segment = "<div class='ui-slider-segment' style='margin-left: " + segmentGap + ";'></div>";

            $(this).prepend(segment.repeat(amount - 2));
        });
    };

    $(function() {

        // Custom Selects
        $("select[name='huge']").selectpicker({style: 'btn-hg btn-primary', menuStyle: 'dropdown-inverse'});
        $("select[name='large']").selectpicker({style: 'btn-lg btn-danger'});
        $("select[name='info']").selectpicker({style: 'btn-info'});
        $("select[name='small']").selectpicker({style: 'btn-sm btn-warning'});

        // Tabs
        $(".nav-tabs a").on('click', function (e) {
            e.preventDefault();
            $(this).tab("show");
        })

        // Tooltips
        $("[data-toggle=tooltip]").tooltip("show");

        // Tags Input
        $(".tagsinput").tagsInput();

        // Add style class name to a tooltips
        $(".tooltip").addClass(function() {
            if ($(this).prev().attr("data-tooltip-style")) {
                return "tooltip-" + $(this).prev().attr("data-tooltip-style");
            }
        });

        // Placeholders for input/textarea
        $("input, textarea").placeholder();

        // Make pagination demo work
        $(".pagination a").on('click', function() {
            $(this).parent().siblings("li").removeClass("active").end().addClass("active");
        });

        $(".btn-group a").on('click', function() {
            $(this).siblings().removeClass("active").end().addClass("active");
        });

        // Disable link clicks to prevent page scrolling
        $('a[href="#fakelink"]').on('click', function (e) {
            e.preventDefault();
        });

        // jQuery UI Spinner
        $.widget( "ui.customspinner", $.ui.spinner, {
            widgetEventPrefix: $.ui.spinner.prototype.widgetEventPrefix,
            _buttonHtml: function() { // Remove arrows on the buttons
                return "" +
                "<a class='ui-spinner-button ui-spinner-up ui-corner-tr'>" +
                    "<span class='ui-icon " + this.options.icons.up + "'></span>" +
                "</a>" +
                "<a class='ui-spinner-button ui-spinner-down ui-corner-br'>" +
                    "<span class='ui-icon " + this.options.icons.down + "'></span>" +
                "</a>";
            }
        });

        $('#spinner-01').customspinner({
            min: -99,
            max: 99
        }).on('focus', function () {
            $(this).closest('.ui-spinner').addClass('focus');
        }).on('blur', function () {
            $(this).closest('.ui-spinner').removeClass('focus');
        });

        // Focus state for append/prepend inputs
        $('.input-group').on('focus', '.form-control', function () {
          $(this).closest('.input-group, .form-group').addClass('focus');
        }).on('blur', '.form-control', function () {
          $(this).closest('.input-group, .form-group').removeClass('focus');
        });

        // Table: Toggle all checkboxes
        $('.table .toggle-all').on('click', function() {
          var ch = $(this).find(':checkbox').prop('checked');
          $(this).closest('.table').find('tbody :checkbox').checkbox(!ch ? 'check' : 'uncheck');
        });

        // Table: Add class row selected
        $('.table tbody :checkbox').on('check uncheck toggle', function (e) {
          var $this = $(this)
            , check = $this.prop('checked')
            , toggle = e.type == 'toggle'
            , checkboxes = $('.table tbody :checkbox')
            , checkAll = checkboxes.length == checkboxes.filter(':checked').length

          $this.closest('tr')[check ? 'addClass' : 'removeClass']('selected-row');
          if (toggle) $this.closest('.table').find('.toggle-all :checkbox').checkbox(checkAll ? 'check' : 'uncheck');
        });

        // jQuery UI Datepicker
        var datepickerSelector = '#datepicker-01';
        $(datepickerSelector).datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: "d MM, yy",
          yearRange: '-1:+1'
        }).prev('.btn').on('click', function (e) {
          e && e.preventDefault();
          $(datepickerSelector).focus();
        });
        $.extend($.datepicker, {_checkOffset:function(inst,offset,isFixed){return offset}});

        // Now let's align datepicker with the prepend button
        $(datepickerSelector).datepicker('widget').css({'margin-left': -$(datepickerSelector).prev('.input-group-btn').find('.btn').outerWidth()});

        // Switch
        $("[data-toggle='switch']").wrap('<div class="switch" />').parent().bootstrapSwitch();

        // make code pretty
        window.prettyPrint && prettyPrint();
    });
})(jQuery);

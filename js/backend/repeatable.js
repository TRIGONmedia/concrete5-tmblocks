(function ($) {

  $.fn.tm_repeatable = function (options) {


    var field = options.field;
    var repeatable = $(this);
    var content = repeatable.find("div.ccm-" + field + "-entries");
    var i = content.attr("data-init-max-sort");
    var _template = _.template($('#template-' + field) .html());

    content.sortable();

    function update(){

      repeatable.find(".repeatable-remove").unbind().click(function(){

        var btn = $(this);

        $("#tm-form-dialog").html("Remove this item?");
        $("#tm-form-dialog").dialog({
          resizable: false,
          height:140,
          modal: false,
          title: "Question",
          buttons: {
            "Yes": function() {
              btn.parent().remove();
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });

      })
    }

    repeatable.find("> button").click(function () {
      i++;
      content.append(_template({
        'i': i,
        'key': i + "-" + Math.floor(Math.random()*1000000000000),
        'name': field + "[" + i + "]",
        'id': field + "_" + i
      }));
      update();
    });

    update();




  };

}(jQuery));


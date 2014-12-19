(function ($) {
  $('[data-toggle="tooltip"]').tooltip();

  if ($('#map').length) {
    var map = AmCharts.makeChart('map', {
      type: 'map',
      theme: 'light',
      pathToImages: 'http://asois.localhost/assets/lib/ammap/images/',
      colorSteps: 10,
      dataProvider: {
        map: 'worldLow'
      },
      areasSettings: {
        autoZoom: true
      },
      valueLegend: {
        right: 10,
        minValue: 'Low',
        maxValue: 'High'
      }
    });

    $('[name="answer"]').change(function () {
      var id = $(this).val();
      var statistics = $.parseJSON($('#statistics').html());

      map.dataProvider.areas = statistics[id];

      map.validateData();
    });
  }

  var $id = $('#answer_id');
  var id = $id.val();

  $('[data-add="answer"]').click(function (event) {
    event.preventDefault();

    var source = $('#answer-template').html();
    var template = Handlebars.compile(source);
    var context = {
      id: id++
    };
    var html = template(context);

    $(this).parent().before(html);
    $id.val(id);
  });

  $(document).on('click', '[data-remove="answer"]', function (event) {
    event.preventDefault();

    $(this).parents('.form-group').remove();
  });
})(jQuery);

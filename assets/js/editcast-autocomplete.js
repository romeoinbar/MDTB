  (function( z ){

    z('#auto-complete-cast').typeahead({
      name     : 'typeahead',
      limit    : 4,
      dataType : 'json',
      valueKey : 'name',
      minLength: 4,
      
      remote: {
        url: z('#auto-complete-cast').data("url") + "/%QUERY",
        filter: function (resp) {
            return resp;
        }
      },
      template: _.template('<div class="media row animated fadeInDown"><a class="pull-left col-sm-1" href="#"><img class="media-object img-responsive" src="<%= image %>" alt="..."></a><div class="media-body col-sm-8"><h4 class="media-heading"><%= name %></h4></div></div>')
    })
    .bind('typeahead:selected', function (obj, datum) {

          var form = $('#actor-form');

          form.append('<input name ="actor-id" type="hidden" value="' + datum.id + '">');
         })

 })( jQuery );

(function( $ ){

 $("#cast").submit(function(e)
  {
    e.preventDefault();

    $.ajax(
    {
      url: $('#edit').data("url") + "/add-cast",
      type: "POST",
      datatype: "json",
      data: $('#cast').serialize(),
      beforeSend: function()
      {
        $('#ajax-loading').show();
      }
    })
    .done(function(data)
    {
      $('#ajax-loading').hide();

      if (data == 'success')
      {
        $('#responses').html('<div class="alert alert-success alert-dismissable">Added actor/character combination successfully, a page reload might be needed for your changes to appear.<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>') 
      }
      else
      {
        $('#responses').html('<div class="alert alert-danger alert-dismissable">Please enter actor and character names.<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>') 
      }

         
    })
    .fail(function(jqXHR, ajaxOptions, thrownError)
    {
        alert('Something went wrong on our end, sorry.');
    });
    return false;
  });

})( jQuery );

(function( $ ){

  $("#edit-relation").submit(function(e)
  {
    e.preventDefault();

    $.ajax(
    {
      url: $('#edit').data("url") + "/edit-cast",
      type: "POST",
      datatype: "json",
      data: $(this).serialize(),
      beforeSend: function()
      {
        $('#ajax-loading').show();
      }
    })
    .done(function(data)
    {
      if (data == 'success')
      {
        $('#responses').html('<div class="alert alert-success alert-dismissable">Updated actor/character information successfully, a page reload might be needed for your changes to appear.<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>')

        $('.edit-cast-modal').modal('hide')
      }
      else
      {
        $('#modal-response').html('<div class="alert alert-danger alert-dismissable">Please enter actor and character names.<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>') 
      }

      $('#ajax-loading').hide();
    })
    .fail(function(jqXHR, ajaxOptions, thrownError)
    {
        alert('Something went wrong on our end, sorry.');
    });
    return false;
  });

})( jQuery );


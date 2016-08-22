$(document).ready(function() {
    // This is the popup iframe view
    $('#popup-component')
        .on('canara.popup.new', function(evt) {


            // remove all the listners
            $(this).find("#popup-holder .modal").off()
            ;

            $(this).find("#popup-holder .modal")
                .on('show.bs.modal', function (evt) {
                    // var $trigger = $(evt.relatedTarget); // Button that triggered the modal
                    var $modal = $(this);
                    var title = $modal.data('quad-load-title'); // Extract info from data-* attributes
                    var url = $modal.data('quad-load-url'); // Extract info from data-* attributes
                    var param = ($modal.data('quad-load-param') !== undefined) ? $modal.data('quad-load-param') : '';
                    // updating the view
                    $modal.find('.modal-title').html(title);
                    $modal.find('i').addClass('hidden');
                    $modal.find('.content-body').load(url + '.body?' + param, function(evt) {
                        // resets the width of the loaded widget
                        var $widget = $modal.find('.widget');
                        if ($widget.length) {
                            $widget
                                .removeClass()
                                .addClass('widget')
                            ;
                        }
                    });
                    // $modal.find('.content-body').html('<iframe src="' + url + '.body" allowtransparency="true" frameborder="0" scrolling="true" width="100%" height="600px"></iframe>');
                    
                })
                .on('hidden.bs.modal', function (evt) {
                    $(this).prev().removeClass('hidden');

                    // reviews from div stack
                    $(this).remove();
                })
                .on('click', 'button.btn-modal-close', function(evt) {
                    $(this).closest('.modal').trigger('canara.popup.close');
                })
                .on('canara.popup.close', function (evt) {
                    evt.preventDefault();
                    var $spinner = $('#popup-loading-spinner');
                    var $modal = $(this).closest('.modal');
                    var id = $modal.data('quad-refresh-id');
                    var url = $modal.data('quad-refresh-url') + '.body';

                    if (!id || !url) {
                        console.log('missing data-quad-refresh-id and/or data-quad-refresh-url');
                        console.log('will refresh/reload the entire page');
                        window.location.reload();
                        return;
                    }

                    var secureajax = new Canara.Libraries.Ajax();
                    var $holder = $('#' + id).parent();

                    $modal.modal('hide');
                    $spinner.modal('show');
                    secureajax.get({
                        url: url,
                        success: function(html) {
                            $holder.html(html);
                            $spinner.modal('hide');
                        }
                    });
                })
                .on('canara.form.updated', function(evt) {
                    evt.stopImmediatePropagation();
                    $(this).trigger('canara.popup.close');
                })
            ;
        })
    ;
    // End of popup iframe view
    
    $(document)
        .on('click', 'a, button', function(evt) {
            var id = $(this).data('quad-popup-id');
            if (!id) {
                return true;
            }

            evt.preventDefault();

            // creates a copy of the html
            var data = $(this).data();
            var $holder = $('#popup-holder');

            // if pop up for this id doesn't exist, build a new one
            if (!$holder.find('#' + id).length) {
                var template = $('#popup-template').html();
                var $template = $(template)
                    .attr('id', id)
                    .appendTo($holder)
                ;

                var attributes = $(this).prop("attributes");
                $.each(attributes, function() {
                    var parts = this.name.split('-');
                    // copy all the data attributes over
                    if (parts[0] == 'data') {
                        $template.attr(this.name, this.value);
                    }
                });


                $('#popup-component').trigger('canara.popup.new');
            }

            $holder.find('.modal')
                .addClass('hidden')
                .last()
                    .removeClass('hidden')
                    .modal('show')
            ;
        })
    ;
});
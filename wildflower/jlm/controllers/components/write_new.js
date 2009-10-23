<<<<<<< HEAD:wildflower/jlm/controllers/components/write_new.js
$.jlm.component('WriteNew', 'wild_posts.wf_index, wild_posts.wf_edit, wild_pages.wf_index, wild_pages.wf_edit, wild_events.wf_index', function() {
=======
$.jlm.component('WriteNew', 'posts.admin_index, posts.admin_edit, pages.admin_index, pages.admin_edit', function() {
>>>>>>> 853920ce542235a426a12ae3ae2e697a80080143:wildflower/jlm/controllers/components/write_new.js
    
    $('#sidebar .add').click(function() {
        // if ($('.new-dialog').size() > 0) {
        //     return false;
        // }
        // Hide sidebar contet
        var sidebarContent = $('#sidebar ul');
        sidebarContent.hide();
        
        var buttonEl = $(this);
        var formAction = buttonEl.attr('href');
        
        var templatePath = 'posts/new_post';
        var parentPageOptions = null;
        if ($.jlm.params.controller == 'pages') {
            templatePath = 'pages/new_page';
            parentPageOptions = $('.all-page-parents').html();
            parentPageOptions = parentPageOptions.replace('[Page]', '[Page]');
            parentPageOptions = parentPageOptions.replace('[parent_id_options]', '[parent_id]');
        }
		else if ($.jlm.params.controller == 'wild_events') {
            templatePath = 'events/new_event';
            var parentPageOptions = null;
        }
        
        var dialogEl = $($.jlm.template(templatePath, { action: formAction, parentPageOptions: parentPageOptions }));
        
        var contentEl = $('#content_pad');
        
        contentEl.append(dialogEl);
        
        var toHeight = 230;
        
        var hiddenContentEls = contentEl.animate({
            height: toHeight
        }, 600, function() {
            // After the animation, focus the title input box
            $('.input:first input', dialogEl).focus();
        }).children().not(dialogEl).hide();
        
        // Bind cancel link
        $('.cancel-edit a', dialogEl).click(function() {
            dialogEl.remove();
            hiddenContentEls.show();
            contentEl.height('auto');
            sidebarContent.show();
            return false;
        });
        
        // Create link
        // TODO - first submit data by AJAX, on success redirect
        $('.submit input', dialogEl).click(function() {
            //$(this).attr('disabled', 'disabled').attr('value', '<l18n>Saving...</l18n>');
            return true;
        });
        
        return false;
    });
    
});
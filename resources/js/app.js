window.Vue = require('vue');

import index from './components/Index.vue';
import create from './components/Create.vue';
import show from './components/Show.vue';

const app = new Vue({
    el: '#app',
    components: {
        index,
        show,
        create
    }
});

(function($){
    $(function() {
        $('#inputSkill').on('keypress', function(e) {
            if(e.which === 13){
                addSkill();

                return false;
            }
        });

        $('#inputSkill').on('blur', function(e) {
            addSkill();
        });

        addEvent();

        function addSkill() {
            if ($('#inputSkill').val() != '') {
                $('#skills').append(
                    $('<li>').append(
                        '<span>'+$('#inputSkill').val()+'</span>'+
                        '<input type="hidden" name="skills[]" value="'+$('#inputSkill').val()+'">'+
                        '<span class="buttonSkill">×</span>'
                    )
                );
            }

            addEvent();

            $('#inputSkill').val('');
        }

        function addEvent(){
            $('.buttonSkill').on('click', function(){
                $(this).parent().remove();
            });
        }

        $('#title').on('input', function() {
            getProjects(location.href);
        });

        $('#organization').on('input', function() {
            getProjects(location.href);
        });

        $('#filtertype').on('input', function() {
            getProjects(location.href);
        });

        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();

            $('#load a').css('color', '#dfecf6');

            var url = $(this).attr('href');
            getProjects(url);
        });

        function getProjects(url) {
            var title = $('#title').val();
            var organization = $('#organization').val();
            var filtertype = $('#filtertype').val();

            $.ajax({
                url : url,
                data: {title: title, organization: organization, filtertype: filtertype}
            }).done(function (data) {
                $('.projects').html(data);
            }).fail(function () {
                alert('Projects could not be loaded.');
            });
        }
    });
})(jQuery);
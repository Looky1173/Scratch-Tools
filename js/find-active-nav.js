$(document).ready(function(){
    navSectionId = $('#nav-section-id').val();
    activeNavSectionIdItem = '#navbar-' + navSectionId;
    $(activeNavSectionIdItem).addClass('active');
})
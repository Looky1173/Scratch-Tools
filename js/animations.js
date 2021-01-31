var animations;
var fadeAnimationDuration = 500;
var registerFadeAnimationDuration = 1000;

$(document).ready(function () {
    if (localStorage.getItem('animations')) {
        animations = localStorage.getItem('animations');
    } else {
        animations = 'on';
    }
    localStorage.setItem('animations', animations);
    if (animations == 'on') {
        $('#animations').prop("checked", true);
        $('#animations-s').prop("checked", true);
        fadeAnimationDuration = 500;
        registerFadeAnimationDuration = 1000;
    } else if (animations == 'off') {
        $('#animations').prop("checked", false);
        $('#animations-s').prop("checked", false);
        fadeAnimationDuration = 0;
        registerFadeAnimationDuration = 0;
    }

    $('#animations').prop("disabled", false);
    $('#animations-s').prop("disabled", false);

    $('#animations').click(function () {
        var animationsSwitch = $('#animations').is(':checked');
        if (animationsSwitch === true) {
            animations = 'on';
            fadeAnimationDuration = 500;
            registerFadeAnimationDuration = 1000;
            $('#animations').prop("checked", true);
            $('#animations-s').prop("checked", true);
        } else if (animationsSwitch === false) {
            animations = 'off';
            fadeAnimationDuration = 0;
            registerFadeAnimationDuration = 0;
            $('#animations').prop("checked", false);
            $('#animations-s').prop("checked", false);
        }
        localStorage.setItem('animations', animations);
    });
    $('#animations-s').click(function () {
        var animationsSwitch = $('#animations-s').is(':checked');
        if (animationsSwitch === true) {
            animations = 'on';
            fadeAnimationDuration = 500;
            registerFadeAnimationDuration = 1000;
            $('#animations').prop("checked", true);
            $('#animations-s').prop("checked", true);
        } else if (animationsSwitch === false) {
            animations = 'off';
            fadeAnimationDuration = 0;
            registerFadeAnimationDuration = 0;
            $('#animations').prop("checked", false);
            $('#animations-s').prop("checked", false);
        }
        localStorage.setItem('animations', animations);
    });
})
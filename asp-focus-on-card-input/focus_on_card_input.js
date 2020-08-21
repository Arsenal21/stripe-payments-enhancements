var FocusOnCardInputHandlerNG = function (data) {
    var parent = this;

    parent.init = function () {
        card.on('ready', function () {
            card.focus();
        })
    }
}
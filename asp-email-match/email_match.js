var EmailMatchNG = function (data) {
	var parent = this;

	parent.submitCanProceed = function () {
		if (jQuery('#asp-custom-field').val() !== jQuery('#email').val()) {
			errorCont.innerHTML = 'Email does not match.';
			errorCont.style.display = 'block';
			vars.data.canProceed = false;
			return false;
		}
		return true;
	}
}
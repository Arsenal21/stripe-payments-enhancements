var MinAmountHandlerNG = function (data) {
	var parent = this;
	parent.min_amount_err_displayed = false;

	parent.submitCanProceed = function () {
		var min_amount_cents = amount_to_cents(vars.data.prod_min_amount, vars.data.currency);
		if (vars.data.amount < min_amount_cents) {
			errorCont.innerHTML = 'Minimum amount is ' + formatMoney(min_amount_cents);
			errorCont.style.display = 'block';
			parent.min_amount_err_displayed = true;
			return false;
		}
	}

	parent.allAmountsUpdated = function () {
		var min_amount_cents = amount_to_cents(vars.data.prod_min_amount, vars.data.currency);
		if (parent.min_amount_err_displayed && min_amount_cents <= vars.data.amount) {
			errorCont.style.display = 'none';
			parent.min_amount_err_displayed = false;
		}
	}
}
; $(function () {
	function getSelectedOption(select) {
		selectOption = select.options[0];
		[].every.call(select.options, function (option) {
			if (option.selected) {
				selectOption = option;
				return false;
			}
			return true;
		});
		return selectOption;
	}
	function initSelector(select) {
		var selectOption, value;
		if ((selectOption = select.options[0]) && selectOption.value === '') {
			value = document.createElement('i');
			selectOption = getSelectedOption(select);
			value.innerText = value.textContent = selectOption.text;

			value.className = (selectOption.value === '' ? 'empty ' : '') + 'value right-selector-placeholder';
			select.parentNode.insertBefore(value, select);
			select.addEventListener('change', function () {
				var selectOption = getSelectedOption(this);
				var placeholder = this.parentNode.querySelector('.right-selector-placeholder');
				placeholder.innerText = placeholder.textContent = selectOption.text;
				placeholder.className = (selectOption.value === '' ? 'empty ' : '') + 'value right-selector-placeholder';
			});
		}
	}
	$('select.right-selector').forEach(function (select) {
		initSelector(select);
	});
});
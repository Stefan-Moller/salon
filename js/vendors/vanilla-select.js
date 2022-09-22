class Select {
	constructor(option) {
		this.select = {
			default: {
				selector: option?.select?.default?.selector || 'select',
				elements: undefined,
			},
			class: {
				parent: option?.select?.class?.parent || 'vanilla-select-wrapper',
				select: {
					default: option?.select?.class?.select?.default || 'vanilla-select',
					show: option?.select?.class?.select?.show || 'vanilla-select_show',
					multiple: option?.select?.class?.select?.multiple || 'vanilla-select_multiple',
					single: option?.select?.class?.select?.single || 'vanilla-select_single',
				},
				btn: option?.select?.class?.btn || 'vanilla-select__btn',
				popup: option?.select?.class?.popup || 'vanilla-select__popup',
				content: option?.select?.class?.content || 'vanilla-select__content',
				input: {
					default: option?.select?.class?.input?.default || 'vanilla-select__input',
					active: option?.select?.class?.input?.active || 'vanilla-select__input_active',
				},
				group: {
					default: option?.select?.class?.group || 'vanilla-select__group',
					active: option?.select?.class?.group || 'vanilla-select__group_active',
				},
				label: option?.select?.class?.label || 'vanilla-select__label',
				list: option?.select?.class?.list || 'vanilla-select__list',
				option: {
					default: option?.select?.class?.option?.default || 'vanilla-select__option',
					selected: option?.select?.class?.option?.selected || 'vanilla-select__option_selected',
					active: option?.select?.class?.option?.active || 'vanilla-select__option_active',
					disabled: option?.select?.class?.option?.disabled || 'vanilla-select__option_disabled',
					hidden: option?.select?.class?.option?.hidden || 'vanilla-select__option_hidden',
				},
				plug: {
					default: option?.select?.class?.plug.default || 'vanilla-select__plug',
					active: option?.select?.class?.plug.active || 'vanilla-select__plug_active',
				},
			},
			multiple: {
				text: option?.select?.multiple?.text || 'Выбрано:',
			},
			search: {
				input: {
					type: option?.select?.search?.input?.type || 'text',
					placeholder: option?.select?.search?.input?.placeholder || 'Поиск...',
				},
				plug: {
					text: option?.select?.search?.plug?.text || 'Нет совпадений...',
				},
			},
			show: false,
		};
	}

	openSelect(select) {
		select.classList.add(this.select.class.select.show);
		this.select.show = true;
	}

	closeSelect(select) {
		select.classList.remove(this.select.class.select.show);
		this.select.show = false;
	}

	selectedMultipleOption(option, btn, selectArr, defaultSelect, defaultSelectActive) {
		const lastOptionSelected = defaultSelect.options[defaultSelect.selectedIndex];

		if (lastOptionSelected && lastOptionSelected.hasAttribute('hidden')) lastOptionSelected.removeAttribute('selected');
		if (option.classList.contains(this.select.class.option.selected)) {
			option.classList.remove(this.select.class.option.selected);
			defaultSelectActive.removeAttribute('selected');
		} else {
			option.classList.add(this.select.class.option.selected);
			defaultSelectActive.setAttribute('selected', 'selected');
		}

		const defaultSelectActiveOptions = selectArr.filter((defaultOption) => defaultOption.hasAttribute('selected'));
		btn.innerText = `${this.select.multiple.text} ${defaultSelectActiveOptions.length}`;
	}

	selectedSingleOption(option, btn, parent, defaultSelect, defaultSelectActive) {
		const optionActive = parent.querySelector(`.${this.select.class.option.default}.${this.select.class.option.selected}`);

		optionActive.classList.remove(this.select.class.option.selected);
		defaultSelect.options[defaultSelect.selectedIndex].removeAttribute('selected');

		option.classList.add(this.select.class.option.selected);
		btn.innerText = option.innerText;
		btn.className = `${this.select.class.btn} ${defaultSelectActive.className}`;
		defaultSelectActive.setAttribute('selected', 'selected');
	}

	selectedOption(select, option) {
		if (option.classList.contains(this.select.class.option.disabled)) return;

		const parent = option.closest(`.${this.select.class.parent}`);
		const btn = parent.querySelector(`.${this.select.class.btn}`);
		const defaultSelect = parent.querySelector('select');
		const selectArr = [...defaultSelect.options];
		const defaultSelectActive = selectArr.find((defaultOption) => defaultOption.value === option.dataset.selectValue);

		if (select.classList.contains(this.select.class.select.multiple)) {
			this.selectedMultipleOption(option, btn, selectArr, defaultSelect, defaultSelectActive);
		} else {
			this.selectedSingleOption(option, btn, parent, defaultSelect, defaultSelectActive);
		}
	}

	hasClick() {
		document.addEventListener('click', (e) => {
			const btn = e.target.closest(`.${this.select.class.btn}`);
			if (!this.select.show && !btn) return;

			const select = e.target.closest(`.${this.select.class.select.default}`);
			const label = e.target.closest(`.${this.select.class.label}`);
			const popup = e.target.closest(`.${this.select.class.popup}`);
			const option = e.target.closest(`.${this.select.class.option.default}`);
			const selectActive = document.querySelector(`.${this.select.class.select.default}.${this.select.class.select.show}`);
			const btnActive = selectActive ? selectActive.querySelector(`.${this.select.class.btn}`) : undefined;

			if (!this.select.show && btn) {
				this.openSelect(select);
			} else if (this.select.show && btn && btn !== btnActive) {
				this.closeSelect(selectActive);
				this.openSelect(select);
			} else if (this.select.show && !popup && !label) {
				this.closeSelect(selectActive);
			} else if (this.select.show && popup && option) {
				this.selectedOption(select, e.target);
				if (!select.classList.contains(this.select.class.select.multiple)) this.closeSelect(selectActive);
			}
		});
	}

	changeSearchInput(input, content, optionArr) {
		const plug = content.querySelector(`.${this.select.class.plug.default}`);
		const optionResult = optionArr.filter((option) => option.innerText.toUpperCase().includes(input.value.toUpperCase()));

		const addActive = () => {
			optionResult.forEach((option) => {
				option.classList.add(this.select.class.option.active);
				const group = option.closest(`.${this.select.class.group.default}`);
				if (group) group.classList.add(this.select.class.group.active);
			});
		};

		const clearActive = () => {
			optionArr.forEach((option) => {
				option.classList.remove(this.select.class.option.active);
				const group = option.closest(`.${this.select.class.group.default}`);
				if (group) group.classList.remove(this.select.class.group.active);
			});
		};

		plug.classList.remove(this.select.class.plug.active);
		clearActive();

		if (input.value.length) {
			input.classList.add(this.select.class.input.active);
			addActive();

			const activeArr = content.querySelectorAll(`.${this.select.class.option.active}`);
			if (!activeArr.length) plug.classList.add(this.select.class.plug.active);
		} else {
			input.classList.remove(this.select.class.input.active);
			plug.classList.remove(this.select.class.plug.active);
			clearActive();
		}
	}

	createOption(list, btn, defaultParent) {
		const child = defaultParent.childNodes;
		const defaultOptions = [...child].filter((option) => option.localName === 'option');

		for (let i = 0; i < defaultOptions.length; i++) {
			const defaultOption = defaultOptions[i];
			const option = document.createElement('li');

			option.className = this.select.class.option.default;
			option.className += ` ${defaultOption.className}`;
			option.dataset.selectValue = defaultOption.value;
			option.innerText = defaultOption.innerText;

			if (defaultOption.hasAttribute('selected')) {
				option.className += ` ${this.select.class.option.selected}`;
				btn.innerText = option.innerText;
				btn.className = `${this.select.class.btn} ${defaultOption.className}`;
			}

			if (defaultOption.hasAttribute('disabled')) {
				option.className += ` ${this.select.class.option.disabled}`;
			}

			if (defaultOption.hasAttribute('hidden')) {
				option.className += ` ${this.select.class.option.hidden}`;
			}

			list.append(option);
		}
	}

	createListSelect(defaultParent, content, btn) {
		const list = document.createElement('ul');
		list.className = this.select.class.list;
		content.append(list);

		this.createOption(list, btn, defaultParent);
	}

	createGroupSelect(defaultSelect, content, btn) {
		const optgroup = defaultSelect.querySelectorAll('optgroup');

		if (!optgroup.length) return;

		optgroup.forEach((defaultGroup) => {
			const group = document.createElement('div');
			group.className = this.select.class.group.default;
			content.append(group);

			const label = document.createElement('b');
			label.className = this.select.class.label;
			label.innerText = defaultGroup.getAttribute('label');
			group.append(label);

			this.createListSelect(defaultGroup, group, btn);
		});
	}

	createSearchSelect(defaultSelect, popup, content) {
		if (!defaultSelect.hasAttribute('autocomplete', 'on')) return;

		const input = document.createElement('input');
		input.setAttribute('type', this.select.search.input.type);
		input.setAttribute('placeholder', this.select.search.input.placeholder);
		input.className = this.select.class.input.default;
		popup.prepend(input);

		const plug = document.createElement('span');
		plug.classList.add(this.select.class.plug.default);
		plug.innerText = this.select.search.plug.text;
		content.append(plug);

		const options = content.querySelectorAll(`.${this.select.class.option.default}`);
		const optionArr = [...options];

		input.addEventListener('input', (e) => this.changeSearchInput(e.target, content, optionArr));
	}

	setTypeSelect(defaultSelect, select) {
		if (defaultSelect.hasAttribute('multiple')) {
			select.classList.add(this.select.class.select.multiple);
		} else {
			select.classList.add(this.select.class.select.single);
		}
	}

	hasSelectedOption(defaultSelect, btn) {
		const selected = defaultSelect.querySelector('option[selected]');
		if (selected) return;

		if (defaultSelect.hasAttribute('multiple')) {
			btn.innerText = `${this.select.multiple.text} 0`;
		} else {
			const options = defaultSelect.querySelectorAll('option');
			options[0].setAttribute('selected', 'selected');
		}
	}

	createSelect() {
		this.select.default.elements.forEach((defaultSelect) => {
			const parent = document.createElement('div');
			parent.className = this.select.class.parent;
			defaultSelect.after(parent);
			parent.append(defaultSelect);

			const select = document.createElement('div');
			select.className = this.select.class.select.default;
			select.className += ` ${defaultSelect.className}`;
			parent.append(select);

			const btn = document.createElement('button');
			btn.setAttribute('type', 'button');
			btn.className = this.select.class.btn;
			select.append(btn);

			const popup = document.createElement('div');
			popup.className = this.select.class.popup;
			select.append(popup);

			const content = document.createElement('div');
			content.className = this.select.class.content;
			popup.append(content);

			this.hasSelectedOption(defaultSelect, btn);
			this.setTypeSelect(defaultSelect, select);
			this.createListSelect(defaultSelect, content, btn);
			this.createGroupSelect(defaultSelect, content, btn);
			this.createSearchSelect(defaultSelect, popup, content);
		});
	}

	hasSelector() {
		this.select.default.elements = document.querySelectorAll(this.select.default.selector);
		if (!this.select.default.elements[0]) return;

		this.createSelect();
		this.hasClick();
	}

	init() {
		this.hasSelector();
	}
}

export default Select;

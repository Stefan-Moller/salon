/* eslint-disable no-console */
class Popup {
	constructor(option) {
		this.element = {
			btn: undefined,
			popup: undefined,
			overlay: undefined,
			iframe: undefined,
		};

		this.status = {
			popup: {
				show: false,
				active: undefined,
			},
			overlay: {
				enabled: undefined,
			},
		};

		this.class = {
			btn: {
				default: option?.class?.btn?.default || 'popup-btn',
				show: option?.class?.btn?.default || 'popup-btn_show',
				close: option?.class?.btn?.close || 'popup-close',
			},
			popup: {
				iframe: option?.class?.popup?.iframe || 'popup-iframe',
			},
			overlay: {
				default: option?.class?.overlay?.default || 'overlay',
				active: option?.class?.overlay?.active || 'overlay_show',
			},
		};
	}

	createIframe(src) {
		this.iframe = this.element.popup.querySelector(`.${this.class.popup.iframe}`);
		const iframe = document.createElement('iframe');
		iframe.allow = 'fullscreen';
		iframe.src = src;

		this.iframe.append(iframe);
	}

	hasOverlay() {
		this.status.overlay.enabled = this.element.btn.dataset.popupOverlay === 'true';
		if (this.status.overlay.enabled) {
			this.element.overlay = document.querySelector(`.${this.class.overlay.default}`);
		}
		return this.status.overlay.enabled && this.element.overlay;
	}

	closePopup(element) {
		const close = element.classList.contains(this.class.btn.close);
		if (!this.status.popup.active) this.status.popup.active = document.querySelector(`.${this.class.popup.show}`);
		const popup = element.closest(`#${this.status.popup.active.id}`);

		if (close || !popup) {
			this.element.btn.classList.remove(this.class.btn.show);
			this.element.popup.removeAttribute('open');
			this.status.popup.show = false;
			if (this.hasOverlay()) this.element.overlay.classList.remove(this.class.overlay.active);
			if (this.iframe) this.iframe.innerHTML = '';
		}
	}

	openPopup() {
		if (this.hasOverlay()) this.element.overlay.classList.add(this.class.overlay.active);

		this.element.btn.classList.add(this.class.btn.show);
		this.element.popup.setAttribute('open', '');
		this.status.popup.active = this.element.popup;
		this.status.popup.show = true;
	}

	hasPopup(btn) {
		const hasPopupNext = btn.nextElementSibling?.id === btn.dataset.popupId;
		this.element.btn = btn;
		this.element.popup = hasPopupNext ? btn.nextElementSibling : document.getElementById(btn.dataset.popupId);

		if (!this.element.popup) {
			console.error(`Not found: #${btn.dataset.popupId}`);
			return;
		}

		if (this.element.btn.dataset.popupSrc) this.createIframe(this.element.btn.dataset.popupSrc);
		this.openPopup();
	}

	hasClick() {
		document.addEventListener('click', (e) => {
			const element = e.target;
			const hasBtn = element.classList.contains(this.class.btn.default);
			const hasAttr = element.dataset.popupId;

			if (this.status.popup.show && hasBtn && hasAttr !== this.status.popup.active.id) {
				this.closePopup(element);
				this.hasPopup(element);
			} else if (this.status.popup.show) {
				this.closePopup(element);
			} else if (hasBtn && hasAttr) {
				this.hasPopup(element);
			}
		});
	}

	init() {
		document.addEventListener('DOMContentLoaded', () => {
			this.hasClick();
		});
	}
}

export default Popup;

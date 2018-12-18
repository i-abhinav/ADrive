function log(log) {
	console.log(log);
}
(function($, d, w, u) {
	var ajaxform = {
		init: function(elem, arg1, arg2, arg3) {
			this.elem = $(elem);
			if(typeof arg1 == 'object') {
				options = arg1 
				onResponse = arg2 || this.elem.data('response');
				onSubmit = arg3 || this.elem.data('submit');
			} else {
				onResponse = arg1 || this.elem.data('response');
				onSubmit = arg2 || this.elem.data('submit');
				options = arg3 
			}
			this.onResponse = onResponse;
			this.onSubmit = onSubmit;
			this.options = $.extend($.fn.ajaxForm.options, options);
			// log(this);
			this.bind();
		},

		bind: function() {
			var self = this;
			self.elem.submit(function(evt) {
				if(evt.isDefaultPrevented()) {
					return false;
				}
				evt.preventDefault();
				// evt.defaultPrevented();
				if(self.onSubmit !== u) {
					var ret = self.onSubmit.call(self.elem, self);
					if(ret === false) {
						return false;
					}
				}
				self.activateLoader();
				self.activateStatus();
				self.sendRequest();
			});
		},

		sendRequest: function() {
			var self = this,
				opt = self.options,
				action = self.elem.attr('action'),
				method = self.elem.attr('method') || 'get',
				dataStr = self.elem.serialize();
			$.ajax({
				url: opt.action || action,
				data: opt.data || dataStr,
				type: opt.method || method,
				success: function(resp) {
					self.response(resp);
				},
				error: function() {
					self.response("<span style='color:#dd2e44'>Something went wrong</span>");
				}
			});
		},

		response: function(resp) {
			this.activateLoader();
			this.activateStatus(resp);
			if(this.onResponse !== u) {
				this.onResponse.call(this.elem, resp, this);
			}
		}, 

		activateLoader: function() {
			var loader = this.options.loader;
			if(loader !== false) {
				this.elem.find(loader).fadeToggle(100);
			}
		},

		activateStatus: function(resp) {
			var select = this.options.status;
			if(select !== u) {
				var status = this.elem.find(select);
				if(resp) {
					status.html(resp).fadeIn(100);
				} else {
					status.fadeOut(100);
				}
			}
		}
	}

	$.fn.ajaxForm = function(arg1, arg2, arg3) {
		this.each(function() {
			var formObj = Object.create(ajaxform);
			formObj.init(this, arg1, arg2, arg3)
		});
	}
	$.fn.ajaxForm.options = {
		loader: '.loader',
		status: '.status'
	};
}(jQuery, document, window));
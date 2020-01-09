define([
	'jquery',
	'uiComponent',
	'mage/validation',
	'ko',
	'Magento_Ui/js/modal/modal'
	], 
	function ($, Component, validation, ko, modal) {
		'use strict';
		var self = this;
		return Component.extend({
			defaults: {
				template: 'Dtn_Knockout/employee'
			},
			listEmployee: ko.observableArray([]),

			initialize: function (config) {
				this._super();
				if (config.employees.length > 0) {
					this.listEmployee(config.employees);
				}
			},

			save: function (dataSave) 
			{
				var employee = {},
				self = this,
				saveData = $(dataSave).serializeArray();
				saveData.forEach(function (entry) {
					employee[entry.name] = entry.value;
				});
				console.log(employee);
				if ($(dataSave).validation() && $(dataSave).validation('isValid')) {
					$.ajax({
						url: 'index/save',
						type: 'POST',
						dataType: 'json',
						data: JSON.stringify(employee),
					})
					.done(function(response) {
						if (response) {
							console.log(response);
							$.each(response, function(i, v) {
								self.listEmployee.remove(function(employee){
								return employee.entity_id == v.entity_id;
							});
								self.listEmployee.push(v);
							});
						}
						$('.action-close').click();
					});
				} 
			},
			delete: function(dataDelete) {
				var confirm_delete = confirm('Are you sure to delete ' + dataDelete.email + '?');
				var self = this;
				if (confirm_delete) {
					var data = dataDelete;
					$.ajax({
						url: 'index/delete',
						type: 'POST',
						dataType: 'json',
						data: data,
					})
					.done(function(response) {
						if (response) {
							console.log(response);
							self.listEmployee.remove(function(employee){
								return employee.entity_id == response.entity_id;
							});
						}
					});
				}
			},
			addNewEmployee: function(object, event) {
				var elementPopup = $("#employee-form-popup");
				var option = {
					'type': 'popup',
					'title': 'Add new employee',
					'responsive': true,
					'buttons': [{
						text: 'Cancel',
						class: 'action',
						click: function () {
							$(elementPopup).find("input").val("");
							this.closeModal();
						}
					}],
					closed: function () {

					}
				};
				$(elementPopup).find("input").val("");
				modal(option, $(elementPopup));
				$(elementPopup).modal("openModal");
			},
			edit: function(employee, event) {
				var elementPopup = $("#employee-form-popup");
				var option = {
					'type': 'popup',
					'title': 'Edit Employee',
					'responsive': true,
					'buttons': [{
						text: 'Cancel',
						class: 'action',
						click: function () {
							$(elementPopup).find("input").val("");
							this.closeModal();
						}
					}],
					closed: function() {

					}
				};
				modal(option, $(elementPopup));
				$(elementPopup).find("input[name=entity_id]").val(employee.entity_id);
				$(elementPopup).find("input[name=email]").val(employee.email);
				$(elementPopup).find("input[name=firstname]").val(employee.firstname);
				$(elementPopup).find("input[name=lastname]").val(employee.lastname);
				$(elementPopup).modal("openModal");
			} 
		});
	}
	);

define(
	[
	'jquery',
	'uiComponent',
	'mage/validation',
	'ko',
	'Magento_Ui/js/modal/modal'
	], 
	function($, Component, validation, ko, modal){
		'use strict';
		var self = this;
		return Component.extend({
			defaults: {
				template: 'Dtn_Knockout/department'
			},
			totalDepartment: ko.observableArray([]),
			initialize: function(config) {
				this._super();
				if (config.departments.length > 0) {
					this.totalDepartment(config.departments);
				}
			},
			addNewDepartment: function(object, event) {
				var elementPopup = $("#department-form-popup");
				var option = {
					'type': 'popup',
					'title': 'Add New Department',
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
				$(elementPopup).find("input").val("");
				$(elementPopup).modal("openModal");
			},
			save: function(data) {
				var department = {},
				self = this,
				saveData = $(data).serializeArray();
				saveData.forEach(function (entry){
					department[entry.name] = entry.value;
				});
				if($(data).validation() && $(data).validation('isValid')) {
					$.ajax({
						url: 'save',
						data: JSON.stringify(department),
						type: "POST",
						dataType: 'json',
					}).done(
					function (response) {
						if (response) {
							$.each(response, function (i, v){
								self.totalDepartment.remove(function(department){
									return department.entity_id == v.entity_id;
								});
								self.totalDepartment.push(v);
							});
						}
						$('.action-close').click();
					}
					)
				}
			},
			delete: function(deleteData) {
				var confirm_delete = confirm('Are you sure to delete ' + deleteData.name +' ?');
				var self = this;
				if(confirm_delete) {
					var data = deleteData;
					$.ajax({
						url: 'delete',
						type: "POST",
						dataType: 'json',
						data: data,
					})
					.done(function(response) {
						if(response) {
							self.totalDepartment.remove(function(department){
								return department.entity_id == response.entity_id;
							});
						}
					});
				}
			},
			edit: function(department, event) {
				var elementPopup = $("#department-form-popup");
				var option = {
					'type': 'popup',
					'title': 'Edit Department',
					'responsive': true,
					'buttons': [{
						text: 'Cancel',
						class: 'action',
						click: function() {
							$(elementPopup).find("input").val("");
							this.closeModal();
						}
					}],
					closed: function() {

					}
				};
				modal(option, $(elementPopup));
				$(elementPopup).find("input[name=entity_id]").val(department.entity_id);
				$(elementPopup).find("input[name=name]").val(department.name);
				$(elementPopup).modal("openModal");
			}
		});
	});
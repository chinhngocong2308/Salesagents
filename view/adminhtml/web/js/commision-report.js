define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
],
    function (ko, Component, urlBuilder, storage) {
        'use strict';

        function viewCommission() {
            var self = this;
            self.commissionProduct = ko.observableArray([]);

            self.getCommission = function () {
                var serviceUrl = urlBuilder.build('admin/ahtsalesagents/search');

                // $.ajax({
                //     url: serviceUrl,
                //       data: { 
                //       user : {
                //         email : 'admin@gmail.com', 
                //         password : 'admin123'
                //       },
                //       vendor_identifier : '3231-43423-fdsdfs'
                //     },
                //     username: 'admin',
                //     password: 'admin123',
                //     dataType: 'jsonp',
                //     success: function(msg) {
                //     var msg = $.parseJSON(msg);
                //     console.log(msg);
                //     }})

                    return storage.post(
                        serviceUrl,
                        [],
                        false
                    )

                }
        
        self.getKeyword = function () {
                        var serviceUrl = urlBuilder.build('admin/ahtsalesagents/search');
                        var data = document.getElementById('commision_report').value;
                        return storage.post(
                            serviceUrl,
                            JSON.stringify({ 'keyword': data }),
                            false
                        ).done(function (response) {
                            alert(response.keyword);
                        }
                        ).fail(function (response) {
                            // code khi fail
                        });
                    };
                self.initialize = function () {
                    this._super();
                    return this;
                };
                self.defaults = { template: 'AHT_Salesagents/commision_report', };
                self.getCommission();
            }

            return Component.extend(new viewCommission());

        }
);
var Vue = require('vue');
var googleMaps = require('google-maps');

module.exports = Vue.extend({
    template: '#advertising-company',

    props: ['advertisingcompany'],

    data: function() {
        return {
            company: {},
            contact: {},
            address: {},
            latLong: {},
        }
    },

    ready: function() {
        $.getJSON('/api/admin/advertisements/companies/' + window.equimundo.advertising_company, function(company) {
            this.company = company.data;
            this.address = company.data.addressRelation.data;
            var latitude = parseFloat(company.data.addressRelation.data.latitude);
            var longitude = parseFloat(company.data.addressRelation.data.longitude);
            this.latLong = {lat: latitude, lng: longitude};
            this.contact = company.data.contactRelation.data;
        }.bind(this));

        setTimeout(this.initMap, 5000);
    },

    methods: {
        initMap: function() {
            var vm = this;
            googleMaps.load(function(google) {
                var mapDiv = document.getElementById('map');
                var map = new google.maps.Map(mapDiv, {
                    center: vm.latLong,
                    zoom: 17
                });

                var marker = new google.maps.Marker({
                    position: vm.latLong,
                    map: map,
                });

                map.set('styles', [
                    {
                        featureType: 'road',
                        elementType: 'geometry.stroke',
                        stylers: [
                            { color: '#40c4a7' },
                            { weight: 1.6 },
                            { lightness: -34 }
                        ]
                    },
                    {
                        featureType: 'landscape',
                        elementType: 'all',
                        stylers: [
                            { color: '#40c4a7' },
                            { saturation: -47 },
                            { lightness: 19 },
                            { gamma: 3.53 }
                        ]
                    }
                ]);
            });
        }
    }
});

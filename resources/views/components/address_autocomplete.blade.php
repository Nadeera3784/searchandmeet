<script async
        src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.api_key')}}&libraries=places&callback=initialize">
</script>
<script>
    const address_id = 'address_autocomplete_input';
    const city_id = 'city_autocomplete_input';
    const state_id = 'state_autocomplete_input';
    const country_id = 'country_autocomplete_input';

    //This code will fill in the address when typed in
    var autocomplete;
    function initialize() {
        var input = document.getElementById(address_id);
        autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener("place_changed",fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var cityInput = document.getElementById(city_id);
        var stateInput = document.getElementById(state_id);
        var addressInput = document.getElementById(address_id);

        console.log(place);
        let address = '';
        let city = '';
        let state = '';
        let country = '';
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            var val = place.address_components[i].long_name;
            if (addressType === 'administrative_area_level_1') {
                state = val;
            }
            else if(addressType === 'locality')
            {
                city = val;
            }
            else if(addressType === 'street_number')
            {
                address = val;
            }
            else if(addressType === 'route')
            {
                address = address + ' ' + val;
            }
            else if(addressType === 'country')
            {
                country = val;
            }
        }
        cityInput.value = city;
        stateInput.value = state;
        addressInput.value = address;

        var countryInput = $("#"+country_id);
        var countryOptions = countryInput.find("option");
        for (var i = 0; i < countryOptions.length; i++) {
            let text = countryOptions[i].text;
            if(text == country)
            {
                const val = countryInput.find("option:contains('"+text+"')").val();
                countryInput.val(val).trigger('change.select2');
            }
        }
    }

</script>

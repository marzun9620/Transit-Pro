@extends('layout')

@section('content')
    <div class="container">
        <h1 class="mb-4">Search for a Trip</h1>

        <form action="{{ route('bus-routes.search') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="starting_point" class="form-label">From</label>
                        <input type="text" id="starting_point" name="starting_point" class="form-control" required autocomplete="off" placeholder="From">
                        <datalist id="starting_point_suggestions">
                            <!-- Suggestions will be dynamically populated here -->
                        </datalist>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ending_point" class="form-label">To</label>
                        <input type="text" id="ending_point" name="ending_point" class="form-control" required autocomplete="off" placeholder="To">
                        <datalist id="ending_point_suggestions">
                            <!-- Suggestions will be dynamically populated here -->
                        </datalist>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="travel_date" class="form-label">Date</label>
                        <input type="date" id="travel_date" name="travel_date" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <script>
        // Sample suggestion data
        const startingPointSuggestions = ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Sylhet', 'Barisal', 'Rangpur', 'Mymensingh', 'Narayanganj', 'Gazipur', 'Comilla', 'Narshingdi', 'Jessore', 'Dinajpur', 'Bogra', 'Tangail', 'Faridpur', 'Jamalpur', 'Pabna', 'Naogaon', 'Cox\'s Bazar', 'Noakhali', 'Lakshmipur', 'Chandpur', 'Feni', 'Brahmanbaria', 'Sirajganj', 'Jhenaidah', 'Shariatpur', 'Kushtia', 'Maulvibazar', 'Madaripur', 'Magura', 'Rajbari', 'Bandarban', 'Natore', 'Chuadanga', 'Joypurhat', 'Habiganj', 'Satkhira', 'Thakurgaon', 'Meherpur', 'Chapainawabganj', 'Bagerhat', 'Khagrachhari', 'Pirojpur', 'Lalmonirhat', 'Kurigram', 'Sherpur', 'Gaibandha', 'Sunamganj', 'Bhola', 'Narsingdi', 'Nawabganj', 'Munshiganj', 'Rangamati', 'Patuakhali', 'Satkhira', 'Kishoreganj', 'Shariatpur', 'Netrokona', 'Moulvibazar', 'Gopalganj', 'Sherpur', 'Lakshmipur'];
        const endingPointSuggestions = ['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Sylhet', 'Barisal', 'Rangpur', 'Mymensingh', 'Narayanganj', 'Gazipur', 'Comilla', 'Narshingdi', 'Jessore', 'Dinajpur', 'Bogra', 'Tangail', 'Faridpur', 'Jamalpur', 'Pabna', 'Naogaon', 'Cox\'s Bazar', 'Noakhali', 'Lakshmipur', 'Chandpur', 'Feni', 'Brahmanbaria', 'Sirajganj', 'Jhenaidah', 'Shariatpur', 'Kushtia', 'Maulvibazar', 'Madaripur', 'Magura', 'Rajbari', 'Bandarban', 'Natore', 'Chuadanga', 'Joypurhat', 'Habiganj', 'Satkhira', 'Thakurgaon', 'Meherpur', 'Chapainawabganj', 'Bagerhat', 'Khagrachhari', 'Pirojpur', 'Lalmonirhat', 'Kurigram', 'Sherpur', 'Gaibandha', 'Sunamganj', 'Bhola', 'Narsingdi', 'Nawabganj', 'Munshiganj', 'Rangamati', 'Patuakhali', 'Satkhira', 'Kishoreganj', 'Shariatpur', 'Netrokona', 'Moulvibazar', 'Gopalganj', 'Sherpur', 'Lakshmipur'];

        const startingPointInput = document.getElementById('starting_point');
        const endingPointInput = document.getElementById('ending_point');

        startingPointInput.addEventListener('input', (event) => {
            const userInput = event.target.value.toLowerCase();
            const filteredSuggestions = startingPointSuggestions.filter(suggestion =>
                suggestion.toLowerCase().startsWith(userInput)
            );
            populateSuggestions('starting_point_suggestions', filteredSuggestions);
        });

        endingPointInput.addEventListener('input', (event) => {
            const userInput = event.target.value.toLowerCase();
            const filteredSuggestions = endingPointSuggestions.filter(suggestion =>
                suggestion.toLowerCase().startsWith(userInput)
            );
            populateSuggestions('ending_point_suggestions', filteredSuggestions);
        });

        function populateSuggestions(datalistId, suggestions) {
            const datalist = document.getElementById(datalistId);
            datalist.innerHTML = '';
            suggestions.forEach(suggestion => {
                const option = document.createElement('option');
                option.value = suggestion;
                datalist.appendChild(option);
            });
        }
    </script>
@endsection

@extends('layouts.admin')

@section('title') Create Time Slot @endsection

@section('content')

@push('page_style')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">

@endpush

    <!-- Basic multiple Column Form section start -->
                <section id="multiple-column-form">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('time_slot.index')}}">Time Slot</a>
                                    </li>
                                    <li class="breadcrumb-item active">Create Time Slot
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
       
                    <div class="row"  >
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Create Time Slot</h4>
                                </div>
                                <div class="card-body">
                                  <form method="POST" action="{{ route('time_slot.store') }}">
                                    @csrf
                                        <div class="row form-container">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="full_name">Select Company <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <select class="form-control" required name="company_id">
                                                        @foreach($company as $key => $val)
                                                        <option {{ old('company_id') == $key ? 'selected' : '' }}  value={{$key}}>{{$val}}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                      
                                                        @if ($errors->has('company_id'))
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $errors->first('company_id') }}</strong>
                                                            </span>
                                                        @endif
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="role">Date <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <input class="form-control" required type="date" name="date" placeholder="Slot Date" value="{{ old('date') }}" />
                                                    @if ($errors->has('date'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $errors->first('date') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($errors->has('slot'))
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $errors->first('slot') }}</strong>
                                                            </span>
                                                        @endif
                                            <div class="row clone_row" id="templateRow">
                                                <div class="col-md-5 col-12">
                                                
                                                    <div class="mb-1">
                                                        <label class="form-label" for="email">Select Slot <span class="text-danger asteric-sign">&#42;</span></label>
                                                        <select class="form-select" required name="slot[]">
                                                            <option {{ old('slot.0') == '8AM - 9AM' ? 'selected' : '' }} value="8AM - 9AM">8AM - 9AM</option>
                                                            <option {{ old('slot.0') == '10AM - 1PM' ? 'selected' : '' }} value="10AM - 1PM">10AM - 1PM</option>
                                                            <option {{ old('slot.0') == '12PM - 3PM' ? 'selected' : '' }} value="12PM - 3PM">12PM - 3PM</option>
                                                            <option {{ old('slot.0') == '2PM - 5PM' ? 'selected' : '' }} value="2PM - 5PM">2PM - 5PM</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="phone_number">No of Slots <span class="text-danger asteric-sign">&#42;</span></label>
                                                        <input id="no_of_slots" required type="text" class="form-control {{ $errors->has('no_of_slots') ? ' is-invalid' : '' }}"    name="no_of_slots[]" placeholder="No of slots" value={{ old("no_of_slots.0") }} >
                                                        @if ($errors->has('no_of_slots'))
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $errors->first('no_of_slots') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <div class="mt-2">
                                                        <button type="button" class=" form-control btn btn-primary me-1 waves-effect waves-float waves-light" id="addRow">+</button>
                                                    </div>
                                                </div>
                                            </div>   
                                            
                                            

                                            <div class="col-12">
                                                <button type="Submit" class="btn btn-primary me-1">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Floating Label Form section end -->



@push('page_script')
<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        const templateRow = document.getElementById("templateRow");
        const addRowButton = document.getElementById("addRow");
        const submitButton = document.querySelector('button[type="Submit"]');
        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("deleteRow")) {
                // Remove the clicked row
                event.target.closest(".row").remove();
            }
        });
        addRowButton.addEventListener("click", function () {
            const newRow = templateRow.cloneNode(true);

            // Clear the input fields in the new row
            newRow.querySelectorAll("select").forEach(function (element) {
                element.value = "9AM - 11PM";
            });

            const addButton = newRow.querySelector("#addRow");
            addButton.textContent = "-";
            addButton.classList.remove("btn-primary");
            addButton.classList.add("btn-danger");
            addButton.classList.add("deleteRow");

            // Insert the new row just before the Submit button
            submitButton.parentElement.insertBefore(newRow, submitButton);
        });
    });
</script> -->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const oldSlots = {!! json_encode(old('slot')) !!};
        const oldNoOfSlots = {!! json_encode(old('no_of_slots')) !!};
        console.log("oldSlots",oldSlots)
        console.log("oldNoOfSlots",oldNoOfSlots)
        if (oldSlots && oldNoOfSlots) {
            for (let i = 1; i < oldSlots.length; i++) {
                // Add rows and populate them with old data
                addRowWithOldData(oldSlots[i], oldNoOfSlots[i]);
            }
        }

        const templateRow = document.getElementById("templateRow");
        const addRowButton = document.getElementById("addRow");
        const submitButton = document.querySelector('button[type="Submit"]');
        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("deleteRow")) {
                // Remove the clicked row
                event.target.closest(".row").remove();
            }
        });
        addRowButton.addEventListener("click", function () {
            const newRow = templateRow.cloneNode(true);

            // Clear the input fields in the new row
            newRow.querySelectorAll("select").forEach(function (element) {
                element.value = "9AM - 11PM";
            });

            // Get the existing button div within the new row
            const buttonDiv = newRow.querySelector(".mt-2");
            const existingButton = newRow.querySelector("#addRow");
            existingButton.style.width = "30px"; 
            existingButton.addEventListener("click", handleAddButtonClick);
            // // Add a "+" button
            // const addButton = document.createElement("button");
            // addButton.textContent = "+";
            // addButton.className = "form-control btn btn-primary me-1 waves-effect waves-float waves-light";
            // addButton.classList.add("addRow"); // Add a unique class for identification
            // addButton.type = "button";

            // Add a "-" button
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "-";
            deleteButton.className = "form-control btn btn-danger deleteRow";
            deleteButton.type = "button";
            deleteButton.style.width = "30px";
            // Append both buttons to the existing button div
            //buttonDiv.appendChild(addButton);
            buttonDiv.appendChild(deleteButton);
            
            // Insert the new row just before the Submit button
            submitButton.parentElement.insertBefore(newRow, submitButton);
        });

        function handleAddButtonClick(){
            const templateRow = document.getElementById("templateRow");
            const addRowButton = document.getElementById("addRow");
            const submitButton = document.querySelector('button[type="Submit"]');
            const newRow = templateRow.cloneNode(true);

            // Clear the input fields in the new row
            newRow.querySelectorAll("select").forEach(function (element) {
                element.value = "9AM - 11PM";
            });

            // Get the existing button div within the new row
            const buttonDiv = newRow.querySelector(".mt-2");
            const existingButton = newRow.querySelector("#addRow");
            existingButton.style.width = "30px"; 
            existingButton.addEventListener("click", handleAddButtonClick);
            // // Add a "+" button
            // const addButton = document.createElement("button");
            // addButton.textContent = "+";
            // addButton.className = "form-control btn btn-primary me-1 waves-effect waves-float waves-light";
            // addButton.classList.add("addRow"); // Add a unique class for identification
            // addButton.type = "button";

            // Add a "-" button
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "-";
            deleteButton.className = "form-control btn btn-danger deleteRow";
            deleteButton.type = "button";
            deleteButton.style.width = "30px";
            // Append both buttons to the existing button div
            //buttonDiv.appendChild(addButton);
            buttonDiv.appendChild(deleteButton);
            
            // Insert the new row just before the Submit button
            submitButton.parentElement.insertBefore(newRow, submitButton);
        }

        function addRowWithOldData(slotValue, noOfSlotsValue) {
            const templateRow = document.getElementById("templateRow");
            const submitButton = document.querySelector('button[type="Submit"]');
            const newRow = templateRow.cloneNode(true);

            // Clear the input fields in the new row
            newRow.querySelectorAll("select").forEach(function (element) {
                element.value = slotValue; // Set the slot value
            });

            newRow.querySelectorAll("input").forEach(function (element) {
                element.value = noOfSlotsValue; // Set the no_of_slots value
            });

            // Get the existing button div within the new row
            const buttonDiv = newRow.querySelector(".mt-2");
            const existingButton = newRow.querySelector("#addRow");
            existingButton.style.width = "30px";
            existingButton.addEventListener("click", handleAddButtonClick);

            // Add a "-" button for deleting this row
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "-";
            deleteButton.className = "form-control btn btn-danger deleteRow";
            deleteButton.type = "button";
            deleteButton.style.width = "30px";
            deleteButton.addEventListener("click", function () {
                newRow.remove(); // Remove the row when the delete button is clicked
            });

            // Append the delete button to the button div
            buttonDiv.appendChild(deleteButton);

            // Insert the new row just before the Submit button
            submitButton.parentElement.insertBefore(newRow, submitButton);
        }
    });

    

</script>

<!-- 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const templateRow = document.getElementById("templateRow");
        const submitButton = document.querySelector('button[type="Submit"]');

        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("deleteRow")) {
                // Remove the clicked row
                event.target.closest(".row").remove();
            }
        });

        document.getElementById("addRow").addEventListener("click", function () {
            const newRow = templateRow.cloneNode(true);

            // Clear the input fields in the new row
            newRow.querySelectorAll("input, select").forEach(function (element) {
                element.value = "";
            });

            // Replace the "+" button with a delete button
            const addButton = newRow.querySelector(".deleteRow");
            addButton.textContent = "-";
            addButton.classList.remove("btn-danger");
            addButton.classList.add("btn-primary");

            // Insert the new row just before the Submit button
            submitButton.parentElement.insertBefore(newRow, submitButton);
        });
    });
</script> -->

@endpush

@endsection
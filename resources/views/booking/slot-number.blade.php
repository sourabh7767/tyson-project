<label class="form-label" for="no_of_slots">No Of Sloats 
    <span class="text-danger asteric-sign">&#42;</span></label>
    <select class="form-control" name="no_of_slots">
        @for($i = 1;$i<=$slotsData->remaining_slots;$i++)
            <option value="{{$i}}">{{$i}}</option>
        @endfor
    </select>
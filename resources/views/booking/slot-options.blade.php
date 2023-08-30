<div class="mb-1">
        <label class="form-label" for="slot">Slots <span class="text-danger asteric-sign">*</span></label><br>
        @foreach($slotsData as $key => $value)
        <input type="radio"  data-id="{{$value->id}}" name="slot" value="{{$value->id}}">
                                                        <label for="html">{{$value->slot}}</label><br>
        @endforeach
</div>
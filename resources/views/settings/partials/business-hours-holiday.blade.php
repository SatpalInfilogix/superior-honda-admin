<div class="tab-pane" id="holidays" role="tabpanel">
    <h5 class="font-weight-bold">Business hours</h5>
    <form action="{{ route('settings.general-setting') }}"
        method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <label class="font-weight-bold">Weekday</label>
            </div>

            <div class="col-lg-4">
                <label class="font-weight-bold">Open Time</label>
            </div>

            <div class="col-lg-4">
                <label class="font-weight-bold">Close Time</label>
            </div>
        </div>
        @php
            if (App\Helpers\SettingHelper::timing('timings')) {
                $weekdays = App\Helpers\SettingHelper::timing(
                    'timings',
                );
            } else {
                $days = [
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday',
                ];
                $weekdays = array_flip($days);
            }
        @endphp
        @foreach ($weekdays as $key => $weekday)
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>{{ $key }}<label>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <input type="time"
                            name="timings[{{ $key }}][start_time]"
                            class="form-control"
                            value="{{ $weekday->start_time ?? ' ' }}">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <input type="time"
                            name="timings[{{ $key }}][end_time]"
                            class="form-control"
                            value="{{ $weekday->end_time ?? '' }}">
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <div class="row">
        <div class="col-xl-2 col-md-12">
            <div id="external-events">
                <h6 class="m-b-30 m-t-20">Events</h6>
                <div class="fc-event ui-draggable ui-draggable-handle">
                    My Event 1</div>
                <div class="fc-event ui-draggable ui-draggable-handle">
                    My Event 2</div>
                <div class="fc-event ui-draggable ui-draggable-handle">
                    My Event 3</div>
                <div class="fc-event ui-draggable ui-draggable-handle">
                    My Event 4</div>
                <div class="fc-event ui-draggable ui-draggable-handle">
                    My Event 5</div>
            </div>
        </div>
        <div class="col-xl-10 col-md-12">
            <div id='calendar'></div>

        </div>
    </div>
</div>
@extends('layouts.frontend.profile')
@section('header-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
@endsection
@section('header-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
@endsection
@section('main-content')
    <div id="calendar"></div>
@endsection
@section('footer-scripts')
    <script>

        $(document).ready(function () {
            @if(request()->get('action') && request()->get('id'))
                toastr.warning('Назначьте дату урока');
            @endif
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                lang: 'ru',
                editable:true,
                header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,agendaWeek,agendaDay'
                },
                events:"{{ route('profile.calendar.show') }}",
                selectable:true,
                selectHelper: true,
                select:function(start, end, allDay)
                {
                    @if(!request()->get('action') && !request()->get('id'))
                        var title = prompt('Event Title:');
                    @else title = 'Новый урок';

                    @endif

                    if(title)
                    {
                        var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

                        var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                        $.ajax({
                            url:"{{ route('profile.calendar.update') }}",
                            type:"POST",
                            data:{
                                title: title,
                                start: start,
                                @if(request()->get('action') && request()->get('id'))
                                action: '{{ request()->get('action') }}',
                                user_id: '{{ request()->get('id') }}',
                                @endif
                                end: end,
                                type: 'add'
                            },
                            success:function(data)
                            {
                                if (data.error) toastr.error("Повторите данное действие позже");
                                else {
                                    toastr.success("Событие успешно созданно");
                                    setTimeout(function() {
                                        location.href = "{{ route('profile.calendar.show') }}"
                                    }, 3000);
                                }
                                calendar.fullCalendar('refetchEvents');
                            }
                        })
                    }
                },
                editable:true,
                eventResize: function(event, delta)
                {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url:"{{ route('profile.calendar.update') }}",
                        type:"POST",
                        data:{
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success:function(response)
                        {
                            if (response.error) toastr.error("Данное событие невозможно обновить");
                            else toastr.success("Событие успешно обновленно");

                            calendar.fullCalendar('refetchEvents');
                        }
                    })
                },
                eventDrop: function(event, delta)
                {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url:"{{ route('profile.calendar.update') }}",
                        type:"POST",
                        data:{
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success:function(response)
                        {
                            if (response.error)toastr.error("Данное событие невозможно обновить");
                            else toastr.success("Событие успешно обновленно");

                            calendar.fullCalendar('refetchEvents');
                        }
                    })
                },

                eventClick:function(event)
                {
                    if(confirm("Are you sure you want to remove it?"))
                    {
                        var id = event.id;
                        $.ajax({
                            url:"{{ route('profile.calendar.update') }}",
                            type:"POST",
                            data:{
                                id:id,
                                type:"delete"
                            },
                            success:function(response)
                            {
                                if (response.error) toastr.error("Данное событие невозможно удалить");
                                else toastr.success("Событие успешно удаленно");

                                calendar.fullCalendar('refetchEvents');
                            }
                        })
                    }
                }
            });

        });

    </script>
@endsection

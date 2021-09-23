<div class="callback-line_block mt-0 mt-md-50">
    <div class="block-container">
        <div class="container">
            <div class="title medium center">
                Остались вопросы? Оставьте заявку на консультацию
            </div>
            <div class="block-content">
                <form action="{{ route('questions.store') }}" method="post">
                    @csrf
                    <div class="form-groups">
                        <div class="form-control">
                            <input type="text" name="Имя" placeholder="Ваше имя" value="{{$userAuth->name ?? ''}}">
                        </div>
                        <div class="form-control">
                            <input type="text" name="email" placeholder="E-mail">
                        </div>
                        <div class="form-control">
                            <input type="text" name="phone" placeholder="+7 (___) ___ ___ __">
                        </div>
                    </div>
                    <button class="button primary">
                        @lang('custom.form_send')
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

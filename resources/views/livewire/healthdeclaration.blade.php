<div>

    <div class="row">
        <div class="col-6">
            <label for="health-declaration">Escolha um Modelo de DS</label>
            <select id="health-declaration" class="form-control" name="health_declaration">
                <option value="">...</option>
                @foreach($quizzes as $quiz)
                    <option value="{{ $quiz->id }}" @if(old('health_declaration', $actual_quiz->id ?? null) == $quiz->id) selected @endif> {{ $quiz->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th><th>Pergunta</th><th>Titular</th>
                        @for($i = 0; $i < $numberOfDependents; $i++)
                            <th>Dependente {{ $i + 1 }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quiz_questions->questions as $k => $question)
                        <tr>
                            <td>{{ $k + 1 }}</td><td>{{ $question->question }}</td><td></td>                            
                            @for($i = 0; $i < $numberOfDependents; $i++)
                                <td></td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        
        $(document).on('change', '#health-declaration', function(e){
            window.livewire.emit('quizChanged', e.target.value);
        })

    });
</script>
@endpush

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
                        <th>#</th><th>Pergunta</th>
                        @for($i = 0; $i < $numberOfDependents; $i++)
                            @if ($i == 0)
                                <th>Titular</th>
                            @else
                                <th>Dependente {{ $i + 1 }}</th>
                            @endif

                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @if ($quiz_questions)
                        @foreach ($quiz_questions->questions as $k => $question)
                            <tr>
                                <td>{{ $k + 1 }}</td><td>{{ $question->question }}</td>                            
                                @for($i = 0; $i < $numberOfDependents; $i++)
                                    @if (isset($answersQuiz[$question->question]['beneficiary_' . $i]['short']) && $answersQuiz[$question->question]['beneficiary_' . $i]['short'] == 'S' )
                                        <td>
                                            <button class="btn btn-primary ds-btn">Sim</button> 
                                            <input type="hidden" name="beneficiary_{{ $i }}[]" value="S">
                                        </td>
                                    @else 
                                        <td>
                                            <button class="btn btn-secondary ds-btn">Não</button> 
                                            <input type="hidden" name="beneficiary_{{ $i }}[]" value="N">
                                        </td>
                                    @endif                                    
                                @endfor
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($specifics as $keySpecific => $specific)
        <div class="form-row mb-1 mt-1">
            <div class="col-1">
                <label for="">Item</label>
                <input name="comment_number[]" class="specific-items form-control" type="text" value="{{ $keySpecific + 2 }}" /> 
            </div>
            <div class="col">
                <label for="">Comentário</label>
                <input type="text" name="comment_item[]" class="form-control" placeholder="especificação" value="{{ old('comment_item.' . $keySpecific, $actual_specifics[$keySpecific]->comment_item ?? null) ?? null }}" />
            </div>
            <div class="col">
                <label for="">Período</label>
                <input type="text" name="period_item[]" class="form-control" placeholder="período da doença" value="{{ old('period_item.' . $keySpecific, $actual_specifics[$keySpecific]->period_item ?? null) ?? null }}" />
            </div>
        </div>
    @endforeach
    
    <div class="form-row mb-4 mt-4" id="health-declaration-comments">
        <div class="col">
            <label for="health-declaration-comments">Comentários da DS</label>
            <textarea name="health_declaration_comments" class="form-control" id="" cols="30" rows="5">{{ old('health_declaration_comments', $accession->comments ?? null) }}</textarea>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        
        $(document).on('change', '#health-declaration', function(e){
            window.livewire.emit('quizChanged', e.target.value);
        })

        $(document).on('click', '.ds-btn', function(e){
            e.preventDefault();

            const btn = $(e.target);

            if (btn.text() == 'Não') {
                btn.text('Sim');
                btn.val('S');
                btn.removeClass('btn-secondary');
                btn.addClass('btn-primary');
                btn.next('input').val('S');

            } else {

                btn.text('Não');
                btn.val('N');
                btn.removeClass('btn-primary');
                btn.addClass('btn-secondary');
                btn.next('input').val('N');

            }
        })

    });
</script>
@endpush

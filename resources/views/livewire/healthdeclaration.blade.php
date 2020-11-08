<div>
    <div class="row">
        <div class="col-6">
            @if ($canEdit) 
                <label for="health-declaration">Escolha um Modelo de DS</label>
                <select id="health-declaration" class="form-control" name="health_declaration">
                    <option value="">...</option>
                    @foreach($quizzes as $quiz)
                        <option value="{{ $quiz->id }}" @if(old('health_declaration', $actual_quiz->id ?? null) == $quiz->id) selected @endif> {{ $quiz->name }}</option>
                    @endforeach
                </select>
            @else 
                <p class="font-weight-bold">{{ $quiz->name }}</p>
            @endif
        </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col">
            <table class="table table-striped" style="width:0;">
                <thead>
                    <tr>
                        <th width="30">#</th><th width="500">Pergunta</th>
                        @for($i = 0; $i < $numberOfDependents; $i++)
                            @if ($i == 0)
                                <th width="120">Titular</th>
                            @else
                                <th width="120">Dependente {{ $i }}</th>
                            @endif

                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @if ($quiz_questions)
                        {{-- {{ dd($answersQuiz) }} --}}
                        @foreach ($quiz_questions->questions as $k => $question)
                            <tr>
                                <td>{{ $k + 1 }}</td><td>{{ $question->question }}</td>                            
                                @for($i = 0; $i < $numberOfDependents; $i++)
                                <td>                                    
                                    @if (isset($answersQuiz[$question->id]['beneficiary_' . $i]['short']) && $answersQuiz[$question->id]['beneficiary_' . $i]['short'] == 'S' )
                                            <button type="button" wire:click.prevent="answerQuestion({{ $question->id }}, {{ $i }}, 'N', {{ $k }})" class="btn btn-primary">Sim</button> 
                                            <input type="hidden" data-index="{{ $k }}" name="beneficiary_{{ $i }}[{{ $k }}]" value="S">
                                    @else 
                                            <button type="button" wire:click.prevent="answerQuestion({{ $question->id }}, {{ $i }}, 'S', {{ $k }})" class="btn btn-secondary">Não</button> 
                                            <input type="hidden" data-index="{{ $k }}" name="beneficiary_{{ $i }}[{{ $k }}]" value="N">
                                    @endif
                                </td>
                                @endfor
                                <input type="hidden" name="question[]" value="{{ $question->id }}">                                    
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if (count($specifics) > 0)
        @php
            asort($specifics)
        @endphp
        @foreach ($specifics as $keySpecific => $specific)
            <div class="form-row mb-1 mt-1">
                <div class="col-1">
                    <label for="">Item</label>
                    <input readonly name="specific_comment_number[]" {{ !$canEdit ? 'readonly' : '' }} class="specific-items form-control" type="text" value="{{ $specific['comment_number'] }}" /> 
                </div>
                <div class="col">
                    <label for="">Beneficiário</label>
                    <input type="text" readonly class="form-control" value="{{ $specific['beneficiary_name'] }}" {{ !$canEdit ? 'readonly' : '' }} />
                    <input type="hidden" name="specific_quiz_id[]" class="form-control" placeholder="especificação" value="{{ old('specific_quiz_id.' . $keySpecific, $specific['quiz_id'] ?? null) ?? null }}" />
                    <input type="hidden" name="specific_question_id[]" class="form-control" value="{{ old('specific_question_id.' . $keySpecific, $specific['question_id'] ?? null) ?? null }}" />
                    <input type="hidden" name="specific_beneficiary_index[]" class="form-control" value="{{ old('specific_beneficiary_index.' . $keySpecific, $specific['beneficiary_index'] ?? null) ?? null }}" />
                
                </div>
                <div class="col">
                    <label for="">Comentário</label>
                    <input type="text" name="specific_comment_item[]" {{ !$canEdit ? 'readonly' : '' }} class="form-control" placeholder="especificação" value="{{ old('specific_comment_item.' . $keySpecific, $specific['comment_item'] ?? null) ?? null }}" required />
                </div>
                <div class="col">
                    <label for="">Período</label>
                    <input type="text" name="specific_period_item[]" {{ !$canEdit ? 'readonly' : '' }} class="form-control" placeholder="período da doença" value="{{ old('specific_period_item.' . $keySpecific, $specific['period_item'] ?? null) ?? null }}" required />
                </div>
            </div>
        @endforeach
    @endif
    
    <div class="form-row mb-4 mt-4" id="health-declaration-comments">
        <div class="col">
            <label for="health-declaration-comments">Comentários da DS</label>
            <textarea {{ !$canEdit ? 'readonly' : '' }} name="health_declaration_comments" class="form-control" id="" cols="30" rows="5">{{ old('health_declaration_comments', $accession->comments ?? null) }}</textarea>
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

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Accession;

class CreateAccessionTest extends TestCase
{
    /**
     * Crete Accession interviewed
     *
     * @return void
     */
    public function testCreateAccessionInterview()
    {
        $accession = factory(Accession::class, 1)->states('interviewProcess')->create();
        
        $this->assertDatabaseHas('accessions', ['interview_validated' => $accession[0]->interview_validated]);
    }

    /**
     * Crete Accession medic analysis
     *
     * @return void
     */
    public function testCreateAccessionMedicAnalysis()
    {
        $accession = factory(Accession::class, 1)->states('medicAnalysis')->create();
        
        $this->assertDatabaseHas('risk_grades', ['risk' => $accession[0]->riskGrade->risk]);

        $this->assertDatabaseHas('suggestions', ['suggestion' => $accession[0]->suggestion->suggestion]);

        $this->assertDatabaseHas('accessions', ['risk_grade_id' => $accession[0]->riskGrade->id, 'suggestion_id' => $accession[0]->suggestion->id]);

    }
}

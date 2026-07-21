<?php

namespace App\Services\Recruitment;

use App\Models\Candidate;
use App\Models\JobApplication;
use App\Repositories\Contracts\CandidateRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CandidateService
{
    public function __construct(
        private CandidateRepositoryInterface $repository
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate(20, $filters);
    }

    public function find(int $id): Candidate
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Candidate
    {
        $data['created_by'] = auth()->id();
        $candidate = $this->repository->create($data);

        if (isset($data['job_posting_id'])) {
            JobApplication::create([
                'job_posting_id' => $data['job_posting_id'],
                'candidate_id' => $candidate->id,
                'stage' => 'applied',
                'status' => 'active',
                'applied_at' => now(),
                'created_by' => auth()->id(),
            ]);
        }

        return $candidate;
    }

    public function update(int $id, array $data): Candidate
    {
        $candidate = $this->repository->findOrFail($id);
        return $this->repository->update($candidate, $data);
    }

    public function delete(int $id): bool
    {
        $candidate = $this->repository->findOrFail($id);
        return $this->repository->delete($candidate);
    }

    public function moveStage(int $id, string $stage): Candidate
    {
        $candidate = $this->repository->findOrFail($id);
        $candidate->applications()->update(['stage' => $stage]);
        return $candidate;
    }

    public function sendOffer(int $id): Candidate
    {
        $candidate = $this->repository->findOrFail($id);
        $candidate->applications()->update(['stage' => 'offer']);
        return $candidate;
    }
}

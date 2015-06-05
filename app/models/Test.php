<?php

class Test extends Eloquent {
	
	protected $table = 'tests';

	protected $primaryKey = 'test_id';

	protected $fillable = array('title', 'description', 'time', 'created_at');

	public $timestamps = false;

	public function isStartGreaterThanNow() {
		if ($this->start_date) {
			$now = Carbon::now();
			$start = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date);

			if ($start->gt($now)) {
				return true;
			}
		}

		return false;
	}

	public function isEndGreaterThanNow() {
		if ($this->end_date) {
			$now = Carbon::now();
			$end = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date);

			if ($end->gt($now)) {
				return true;
			}
		}

		return false;
	}

	public function isBetweenNow() {
		if ($this->start_date && $this->end_date) {
			$now = Carbon::now();
			$start = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date);
			$end = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date);

			if ($now->between($start, $end)) {
				return true;
			}
		}

		return false;
	}

	public function isFinalized() {
		return $this->isPublished() && !$this->isEndGreaterThanNow();
	}

	public function isEditable() {
		return !$this->start_date && !$this->end_date;
	}

	public function isPublished() {
		return $this->start_date && $this->end_date;
	}

	public function hasQualification(User $user) {
		return $user->tests->contains($this->test_id);
	}

	public function isExpired(User $user) {
		if ($user->tests->contains($this->test_id)) {
			return false;
		}

		if ($this->start_date && $this->end_date) {
			$now = Carbon::now();
			$end = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date);

			if ($now->gt($end)) {
				return true;
			}
		}

		return false;
	}

	public function canStart(User $user) {
		if ($this->start_date && $this->end_date) {
			$now = Carbon::now();
			$start = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date);
			$end = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date);

			if ($user->tests->contains($this->test_id)) {
				$pivot = $user->tests->find($this->test_id)->pivot;

				if ($pivot->is_finished) {
					return false;
				}

				if ($pivot->started_at) {
					$started = Carbon::createFromFormat('Y-m-d H:i:s', $pivot->started_at);

					if ($now->diffInMinutes($started) < $this->time) {
						return true;
					}

					return false;
				}
			}

			if ($now->between($start, $end)) {
				return true;
			}
		}

		return false;
	}

	public function isFinished(User $user) {
		if ($user->tests->contains($this->test_id)) {
			$pivot = $user->tests->find($this->test_id)->pivot;

			if ($pivot->is_finished) {
				return true;
			}
		}

		return false;
	}

	public function userPoints(User $user) {
		$points = 0;

		if (!$this->isFinished($user)) {
			return $points;
		}
		
		$user->questions->each(function($question) use (&$points) {
			if ($question->test->test_id === $this->test_id) {
				$question->answers->each(function($answer) use ($question, &$points) {
					if ($answer->answer_text == $question->pivot->answer_text) {
						if ($answer->is_correct) {
							$points += $question->points;
						} else {
							if ($question->is('multiple')) {
								$points -= $question->points;
							}
						}
					}
				});
			}
		});

		return $points;
	}

	public function totalPoints() {
		$points = 0;

		$this->questions->each(function($question) use (&$points) {
			if ($question->type === 'open' || $question->type === 'choice') {
				$points += $question->points;
			} else {
				$question->answers->each(function($answer) use ($question, &$points) {
					if ($answer->is_correct) {
						$points += $question->points;
					}
				});
			}
		});

		return $points;
	}

	public function hasQuestions() {
		return 0 !== $this->questions->count();
	}

	public function getStartDateFormatAttribute() {
		if ($this->attributes['start_date']) {
			$date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['start_date']);

			return $date->formatLocalized('%A %d %B %Y') . ' - ' . $date->format('h:i:s A');
		}
	}

	public function getEndDateFormatAttribute($value) {
		if ($this->attributes['end_date']) {
			$date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['end_date']);

			return $date->formatLocalized('%A %d %B %Y') . ' - ' . $date->format('h:i:s A');
		}
	}

	public function course() {
		return $this->belongsTo('Course');
	}

	public function questions() {
		return $this->hasMany('Question')->with('answers');
	}

	public function students() {
		return $this->belongsToMany('User', 'users_tests')->withPivot('started_at', 'is_finished', 'qualification');
	}
}
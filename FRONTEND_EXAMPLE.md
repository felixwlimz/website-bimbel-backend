# Frontend Implementation Example

## Display Multiple Question Sets

### Component: PackageDetail.tsx

```tsx
import { useEffect, useState } from 'react'
import { useParams } from 'react-router'

interface QuestionSet {
  id: string
  name: string
  question_count: number
  total_weight: number
}

export function PackageDetail() {
  const { packageId } = useParams()
  const [sets, setSets] = useState<QuestionSet[]>([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    // Fetch all question sets
    fetch(`/api/packages/${packageId}/sets`)
      .then(res => res.json())
      .then(data => {
        setSets(data)
        setLoading(false)
      })
  }, [packageId])

  if (loading) return <div>Loading...</div>

  return (
    <div className="space-y-6">
      <h1 className="text-3xl font-bold">Question Sets</h1>
      
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {sets.map(set => (
          <div key={set.id} className="border rounded-lg p-4 hover:shadow-lg transition">
            <h2 className="text-xl font-semibold mb-2">{set.name}</h2>
            <div className="space-y-1 text-sm text-gray-600">
              <p>📝 Questions: {set.question_count}</p>
              <p>⚖️ Total Weight: {set.total_weight}</p>
            </div>
            <button className="mt-4 w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
              View Questions
            </button>
          </div>
        ))}
      </div>
    </div>
  )
}
```

## Display Per-SubTopic Scores

### Component: TestResults.tsx

```tsx
import { useEffect, useState } from 'react'
import { useParams } from 'react-router'

interface SubTopicScore {
  sub_topic_id: string
  sub_topic_name: string
  total_questions: number
  correct_answers: number
  total_score: number
  passing_grade: number
  is_passed: boolean
  percentage: number
}

interface TestResult {
  answer_sheet: {
    id: string
    package_id: string
    total_score: number
    passing: boolean
    submitted_at: string
  }
  package: {
    title: string
    passing_grade: number
  }
  sub_topic_scores: SubTopicScore[]
}

export function TestResults() {
  const { sheetId } = useParams()
  const [result, setResult] = useState<TestResult | null>(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    // Fetch detailed results with breakdown
    fetch(`/api/results/${sheetId}`)
      .then(res => res.json())
      .then(data => {
        setResult(data)
        setLoading(false)
      })
  }, [sheetId])

  if (loading) return <div>Loading...</div>
  if (!result) return <div>No results found</div>

  const { answer_sheet, package: pkg, sub_topic_scores } = result
  const totalPercentage = (answer_sheet.total_score / sub_topic_scores.reduce((sum, s) => sum + s.total_score, 0)) * 100

  return (
    <div className="space-y-8">
      {/* Overall Result */}
      <div className={`p-6 rounded-lg ${answer_sheet.passing ? 'bg-green-50' : 'bg-red-50'}`}>
        <h1 className="text-3xl font-bold mb-2">
          {answer_sheet.passing ? '🎉 Selamat! Anda Lulus' : '❌ Hasil Ujian'}
        </h1>
        <p className="text-gray-600 mb-4">{pkg.title}</p>
        
        <div className="grid grid-cols-2 gap-4">
          <div>
            <p className="text-sm text-gray-600">Nilai Akhir</p>
            <p className="text-4xl font-bold">{Math.round(totalPercentage)}%</p>
          </div>
          <div>
            <p className="text-sm text-gray-600">Passing Grade</p>
            <p className="text-4xl font-bold">{pkg.passing_grade}%</p>
          </div>
        </div>
      </div>

      {/* Per-SubTopic Breakdown */}
      <div>
        <h2 className="text-2xl font-bold mb-4">Breakdown Per Sub Bab</h2>
        
        <div className="space-y-4">
          {sub_topic_scores.map(score => (
            <div key={score.sub_topic_id} className="border rounded-lg p-4">
              <div className="flex items-center justify-between mb-3">
                <h3 className="text-lg font-semibold">{score.sub_topic_name}</h3>
                <span className={`px-3 py-1 rounded-full text-sm font-semibold ${
                  score.is_passed 
                    ? 'bg-green-100 text-green-800' 
                    : 'bg-red-100 text-red-800'
                }`}>
                  {score.is_passed ? '✓ Passed' : '✗ Failed'}
                </span>
              </div>

              {/* Progress Bar */}
              <div className="mb-3">
                <div className="flex justify-between text-sm text-gray-600 mb-1">
                  <span>{score.correct_answers}/{score.total_questions} Correct</span>
                  <span>{score.percentage}%</span>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div
                    className={`h-2 rounded-full transition-all ${
                      score.is_passed ? 'bg-green-500' : 'bg-red-500'
                    }`}
                    style={{ width: `${score.percentage}%` }}
                  />
                </div>
              </div>

              {/* Details */}
              <div className="grid grid-cols-3 gap-4 text-sm">
                <div>
                  <p className="text-gray-600">Score</p>
                  <p className="font-semibold">{score.total_score}</p>
                </div>
                <div>
                  <p className="text-gray-600">Passing Grade</p>
                  <p className="font-semibold">{score.passing_grade}%</p>
                </div>
                <div>
                  <p className="text-gray-600">Status</p>
                  <p className="font-semibold">{score.is_passed ? 'Passed' : 'Failed'}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Summary Statistics */}
      <div className="bg-gray-50 p-6 rounded-lg">
        <h3 className="text-lg font-semibold mb-4">Summary</h3>
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div>
            <p className="text-sm text-gray-600">Total Questions</p>
            <p className="text-2xl font-bold">
              {sub_topic_scores.reduce((sum, s) => sum + s.total_questions, 0)}
            </p>
          </div>
          <div>
            <p className="text-sm text-gray-600">Correct Answers</p>
            <p className="text-2xl font-bold">
              {sub_topic_scores.reduce((sum, s) => sum + s.correct_answers, 0)}
            </p>
          </div>
          <div>
            <p className="text-sm text-gray-600">Passed Sub-Topics</p>
            <p className="text-2xl font-bold">
              {sub_topic_scores.filter(s => s.is_passed).length}/{sub_topic_scores.length}
            </p>
          </div>
          <div>
            <p className="text-sm text-gray-600">Submitted At</p>
            <p className="text-sm font-semibold">
              {new Date(answer_sheet.submitted_at).toLocaleDateString()}
            </p>
          </div>
        </div>
      </div>
    </div>
  )
}
```

## Display Notification with Breakdown

### Component: NotificationItem.tsx

```tsx
interface Notification {
  id: string
  title: string
  message: string
  type: 'success' | 'info' | 'warning' | 'error'
  action_url?: string
  created_at: string
  is_read: boolean
}

export function NotificationItem({ notification }: { notification: Notification }) {
  const formatMessage = (message: string) => {
    // Parse message with breakdown
    const lines = message.split('\n')
    return lines.map((line, idx) => (
      <div key={idx} className="text-sm">
        {line}
      </div>
    ))
  }

  const bgColor = {
    success: 'bg-green-50 border-green-200',
    info: 'bg-blue-50 border-blue-200',
    warning: 'bg-yellow-50 border-yellow-200',
    error: 'bg-red-50 border-red-200',
  }[notification.type]

  const textColor = {
    success: 'text-green-800',
    info: 'text-blue-800',
    warning: 'text-yellow-800',
    error: 'text-red-800',
  }[notification.type]

  return (
    <div className={`border rounded-lg p-4 ${bgColor} ${!notification.is_read ? 'font-semibold' : ''}`}>
      <div className="flex items-start justify-between mb-2">
        <h4 className={`font-semibold ${textColor}`}>{notification.title}</h4>
        <span className="text-xs text-gray-500">
          {new Date(notification.created_at).toLocaleDateString()}
        </span>
      </div>
      
      <div className="text-gray-700 mb-3 font-mono text-xs whitespace-pre-wrap">
        {formatMessage(notification.message)}
      </div>

      {notification.action_url && (
        <a
          href={notification.action_url}
          className="text-blue-600 hover:text-blue-800 text-sm font-semibold"
        >
          View Details →
        </a>
      )}
    </div>
  )
}
```

## Admin Panel: Create Question Set

### Component: CreateQuestionSet.tsx

```tsx
import { useState } from 'react'
import { useParams } from 'react-router'

export function CreateQuestionSet() {
  const { packageId } = useParams()
  const [name, setName] = useState('')
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState('')
  const [success, setSuccess] = useState('')

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setLoading(true)
    setError('')
    setSuccess('')

    try {
      const response = await fetch(`/api/packages/${packageId}/sets`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
        },
        body: JSON.stringify({ name }),
      })

      if (!response.ok) throw new Error('Failed to create set')

      const data = await response.json()
      setSuccess(`Question set "${name}" created successfully!`)
      setName('')
      
      // Refresh page or update state
      window.location.reload()
    } catch (err) {
      setError(err instanceof Error ? err.message : 'An error occurred')
    } finally {
      setLoading(false)
    }
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div>
        <label className="block text-sm font-medium mb-2">Question Set Name</label>
        <input
          type="text"
          value={name}
          onChange={(e) => setName(e.target.value)}
          placeholder="e.g., Trigonometri"
          className="w-full border rounded-lg px-3 py-2"
          required
        />
      </div>

      {error && <div className="text-red-600 text-sm">{error}</div>}
      {success && <div className="text-green-600 text-sm">{success}</div>}

      <button
        type="submit"
        disabled={loading}
        className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50"
      >
        {loading ? 'Creating...' : 'Create Question Set'}
      </button>
    </form>
  )
}
```

## Admin Panel: Add Questions to Set

### Component: AddQuestionsToSet.tsx

```tsx
import { useState } from 'react'
import { useParams } from 'react-router'

interface Question {
  title: string
  content: string
  weight: number
  explanation: string
  options: Array<{
    key: string
    content: string
    is_correct: boolean
    score: number
  }>
}

export function AddQuestionsToSet() {
  const { setId } = useParams()
  const [questions, setQuestions] = useState<Question[]>([
    {
      title: '',
      content: '',
      weight: 1,
      explanation: '',
      options: [
        { key: 'A', content: '', is_correct: false, score: 0 },
        { key: 'B', content: '', is_correct: false, score: 0 },
        { key: 'C', content: '', is_correct: false, score: 0 },
        { key: 'D', content: '', is_correct: false, score: 0 },
      ],
    },
  ])
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState('')

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setLoading(true)
    setError('')

    try {
      const response = await fetch(`/api/sets/${setId}/questions`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
        },
        body: JSON.stringify({ questions }),
      })

      if (!response.ok) throw new Error('Failed to add questions')

      alert('Questions added successfully!')
      window.location.reload()
    } catch (err) {
      setError(err instanceof Error ? err.message : 'An error occurred')
    } finally {
      setLoading(false)
    }
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      {questions.map((question, qIdx) => (
        <div key={qIdx} className="border rounded-lg p-4 space-y-4">
          <h3 className="font-semibold">Question {qIdx + 1}</h3>

          <input
            type="text"
            value={question.title}
            onChange={(e) => {
              const newQuestions = [...questions]
              newQuestions[qIdx].title = e.target.value
              setQuestions(newQuestions)
            }}
            placeholder="Question title"
            className="w-full border rounded px-3 py-2"
            required
          />

          <textarea
            value={question.content}
            onChange={(e) => {
              const newQuestions = [...questions]
              newQuestions[qIdx].content = e.target.value
              setQuestions(newQuestions)
            }}
            placeholder="Question content"
            className="w-full border rounded px-3 py-2"
            required
          />

          <div className="grid grid-cols-2 gap-4">
            <input
              type="number"
              value={question.weight}
              onChange={(e) => {
                const newQuestions = [...questions]
                newQuestions[qIdx].weight = parseInt(e.target.value)
                setQuestions(newQuestions)
              }}
              placeholder="Weight"
              className="border rounded px-3 py-2"
              min="1"
            />
            <textarea
              value={question.explanation}
              onChange={(e) => {
                const newQuestions = [...questions]
                newQuestions[qIdx].explanation = e.target.value
                setQuestions(newQuestions)
              }}
              placeholder="Explanation"
              className="border rounded px-3 py-2"
            />
          </div>

          {/* Options */}
          <div className="space-y-2">
            <h4 className="font-semibold text-sm">Options</h4>
            {question.options.map((option, oIdx) => (
              <div key={oIdx} className="flex gap-2">
                <input
                  type="text"
                  value={option.content}
                  onChange={(e) => {
                    const newQuestions = [...questions]
                    newQuestions[qIdx].options[oIdx].content = e.target.value
                    setQuestions(newQuestions)
                  }}
                  placeholder={`Option ${option.key}`}
                  className="flex-1 border rounded px-3 py-2 text-sm"
                />
                <label className="flex items-center gap-2">
                  <input
                    type="checkbox"
                    checked={option.is_correct}
                    onChange={(e) => {
                      const newQuestions = [...questions]
                      newQuestions[qIdx].options[oIdx].is_correct = e.target.checked
                      newQuestions[qIdx].options[oIdx].score = e.target.checked ? 1 : 0
                      setQuestions(newQuestions)
                    }}
                  />
                  <span className="text-sm">Correct</span>
                </label>
              </div>
            ))}
          </div>
        </div>
      ))}

      {error && <div className="text-red-600">{error}</div>}

      <button
        type="submit"
        disabled={loading}
        className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50"
      >
        {loading ? 'Adding...' : 'Add Questions'}
      </button>
    </form>
  )
}
```

## Key Features

✅ Display multiple question sets per package
✅ Show per-subtopic scores with breakdown
✅ Display detailed notifications with breakdown
✅ Admin panel to create question sets
✅ Admin panel to add questions to sets
✅ Responsive design
✅ Real-time feedback

## Integration

1. Import components in your pages
2. Connect to API endpoints
3. Handle loading and error states
4. Update state management as needed
5. Style according to your design system

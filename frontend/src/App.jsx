import React, { useEffect, useState } from 'react';
import { assessmentService } from './api/assessmentService';
import { config } from './api/client';
import { getErrorMessage } from './utils/errorHandler';
import AssessmentDetail from './components/AssessmentDetail';
import AssessmentForm from './components/AssessmentForm';
import AssessmentList from './components/AssessmentList';
import QuestionForm from './components/QuestionForm';

export default function App() {
  const [assessments, setAssessments] = useState([]);
  const [pagination, setPagination] = useState({ page: 1, total_pages: 0 });
  const [selected, setSelected] = useState(null);
  const [questions, setQuestions] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const loadAssessments = async (page = 1) => {
    setLoading(true); setError('');
    try { const result = await assessmentService.getAssessments(page); setAssessments(result.items || []); setPagination(result.pagination || { page, total_pages: 0 }); }
    catch (err) { setError(getErrorMessage(err)); }
    finally { setLoading(false); }
  };

  const selectAssessment = async (assessment) => {
    setSelected(assessment); setLoading(true); setError('');
    try { setQuestions(await assessmentService.getQuestions(assessment.id) || []); }
    catch (err) { setError(getErrorMessage(err)); }
    finally { setLoading(false); }
  };

  useEffect(() => { loadAssessments(); }, []);

  const createAssessment = async (data) => { try { await assessmentService.createAssessment(data); await loadAssessments(1); } catch (err) { setError(getErrorMessage(err)); } };
  const createQuestion = async ({ assessmentId, content, answer, score }) => {
    try {
      const question = await assessmentService.createQuestion({ assessment_id: assessmentId, content });
      if (answer) await assessmentService.createAnswer({ question_id: question.id, content: answer, score });
      await selectAssessment(selected);
    } catch (err) { setError(getErrorMessage(err)); }
  };

  return <div className="ma-app">
    <h2>Mini Assessment</h2>
    {error && <div className="ma-error" role="alert">{error}</div>}
    {config.canManage && !selected && <AssessmentForm onSubmit={createAssessment} />}
    {selected ? <>
      {config.canManage && <QuestionForm assessmentId={selected.id} onSubmit={createQuestion} />}
      <AssessmentDetail assessment={selected} questions={questions} loading={loading} onBack={() => { setSelected(null); setQuestions([]); loadAssessments(); }} />
    </> : <AssessmentList assessments={assessments} pagination={pagination} loading={loading} onSelect={selectAssessment} onPageChange={loadAssessments} />}
  </div>;
}

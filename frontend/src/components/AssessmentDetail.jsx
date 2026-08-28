import React, { useState } from 'react';

export default function AssessmentDetail({ assessment, questions, loading, onBack, canManage, onSubmit }) {
  const [selectedAnswers, setSelectedAnswers] = useState({});
  const [result, setResult] = useState('');

  const submit = async (event) => {
    event.preventDefault();
    const answers = Object.entries(selectedAnswers).map(([question_id, answer_id]) => ({ question_id: Number(question_id), answer_id: Number(answer_id) }));
    const response = await onSubmit(answers);
    if (response) setResult(`Da nop bai. Tong diem: ${response.score}.`);
  };

  return (
    <section>
      <button type="button" className="ma-link" onClick={onBack}>&lt;- Quay lai danh sach</button>
      <h3>{assessment.title} <span className={`ma-badge ma-${assessment.status}`}>{assessment.status}</span></h3>
      <p>{assessment.description || 'Khong co mo ta.'}</p>
      <hr />
      <h4>Danh sach cau hoi ({questions.length})</h4>
      {loading ? <p className="ma-muted">Dang tai cau hoi...</p> : !questions.length ? <p className="ma-muted">Chua co cau hoi nao.</p> : (
        <form onSubmit={submit}>{questions.map((question, index) => (
          <article className="ma-question" key={question.id}>
            <strong>Cau {index + 1}: {question.content}</strong>
            <ol>{(question.answers || []).map((answer) => <li key={answer.id}><label><input type="radio" name={`question-${question.id}`} value={answer.id} onChange={() => setSelectedAnswers({ ...selectedAnswers, [question.id]: answer.id })} /> {answer.content} {canManage && <small>({answer.score} diem)</small>}</label></li>)}</ol>
          </article>
        ))}<button type="submit" disabled={Object.keys(selectedAnswers).length !== questions.length}>Nop bai</button>{result && <p role="status">{result}</p>}</form>
      )}
    </section>
  );
}

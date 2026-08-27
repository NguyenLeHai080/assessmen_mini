import React from 'react';

export default function AssessmentDetail({ assessment, questions, loading, onBack }) {
  return (
    <section>
      <button type="button" className="ma-link" onClick={onBack}>&lt;- Quay lai danh sach</button>
      <h3>{assessment.title} <span className={`ma-badge ma-${assessment.status}`}>{assessment.status}</span></h3>
      <p>{assessment.description || 'Khong co mo ta.'}</p>
      <hr />
      <h4>Danh sach cau hoi ({questions.length})</h4>
      {loading ? <p className="ma-muted">Dang tai cau hoi...</p> : !questions.length ? <p className="ma-muted">Chua co cau hoi nao.</p> : (
        questions.map((question, index) => (
          <article className="ma-question" key={question.id}>
            <strong>Cau {index + 1}: {question.content}</strong>
            <ol>{(question.answers || []).map((answer) => <li key={answer.id}>{answer.content} <small>({answer.score} diem)</small></li>)}</ol>
          </article>
        ))
      )}
    </section>
  );
}

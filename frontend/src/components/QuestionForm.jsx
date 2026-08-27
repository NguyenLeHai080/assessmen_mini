import React, { useState } from 'react';

export default function QuestionForm({ assessmentId, onSubmit }) {
  const [content, setContent] = useState('');
  const [answer, setAnswer] = useState('');
  const [score, setScore] = useState(0);

  const submit = async (event) => {
    event.preventDefault();
    if (!content.trim()) return;
    await onSubmit({ assessmentId, content: content.trim(), answer: answer.trim(), score: Number(score) || 0 });
    setContent(''); setAnswer(''); setScore(0);
  };

  return (
    <form className="ma-form" onSubmit={submit}>
      <h4>Them cau hoi mau</h4>
      <textarea value={content} onChange={(event) => setContent(event.target.value)} placeholder="Noi dung cau hoi" rows="2" required />
      <div className="ma-form-row"><input value={answer} onChange={(event) => setAnswer(event.target.value)} placeholder="Dap an (tuy chon)" /><input type="number" value={score} onChange={(event) => setScore(event.target.value)} min="0" placeholder="Diem" /></div>
      <button type="submit">Them cau hoi</button>
    </form>
  );
}

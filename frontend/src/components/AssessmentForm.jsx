import React, { useState } from 'react';

export default function AssessmentForm({ onSubmit }) {
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [status, setStatus] = useState('draft');

  const submit = async (event) => {
    event.preventDefault();
    if (!title.trim()) return;
    await onSubmit({ title: title.trim(), description, status });
    setTitle(''); setDescription(''); setStatus('draft');
  };

  return (
    <form className="ma-form" onSubmit={submit}>
      <h4>Tao bai danh gia</h4>
      <div className="ma-form-row"><input value={title} onChange={(event) => setTitle(event.target.value)} placeholder="Tieu de" required /><select value={status} onChange={(event) => setStatus(event.target.value)}><option value="draft">Draft</option><option value="published">Published</option><option value="archived">Archived</option></select></div>
      <textarea value={description} onChange={(event) => setDescription(event.target.value)} placeholder="Mo ta" rows="3" />
      <button type="submit">Tao assessment</button>
    </form>
  );
}

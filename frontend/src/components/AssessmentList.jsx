import React from 'react';

export default function AssessmentList({ assessments, pagination, loading, onSelect, onPageChange }) {
  if (loading) return <p className="ma-muted">Dang tai danh sach bai danh gia...</p>;
  if (!assessments.length) return <p className="ma-muted">Khong co bai danh gia nao.</p>;

  return (
    <>
      <div className="ma-table-wrap">
        <table className="ma-table">
          <thead><tr><th>ID</th><th>Tieu de</th><th>Trang thai</th><th /></tr></thead>
          <tbody>
            {assessments.map((item) => (
              <tr key={item.id}>
                <td>{item.id}</td>
                <td><strong>{item.title}</strong><br /><small>{item.description}</small></td>
                <td><span className={`ma-badge ma-${item.status}`}>{item.status}</span></td>
                <td><button type="button" onClick={() => onSelect(item)}>Xem chi tiet</button></td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
      {pagination.total_pages > 1 && (
        <div className="ma-pagination">
          {Array.from({ length: pagination.total_pages }, (_, index) => index + 1).map((page) => (
            <button key={page} type="button" disabled={page === pagination.page} onClick={() => onPageChange(page)}>{page}</button>
          ))}
        </div>
      )}
    </>
  );
}

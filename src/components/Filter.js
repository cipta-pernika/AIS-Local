// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable jsx-a11y/label-has-associated-control */
import { React, useMemo, useState } from "react";
import { useAsyncDebounce } from "react-table";

// Component for Global Filter
export const GlobalFilter = ({
  globalFilter,
  setGlobalFilter
}) => {
  const [value, setValue] = useState(globalFilter);

  // eslint-disable-next-line @typescript-eslint/no-shadow
  const onChange = useAsyncDebounce((value) => {
    setGlobalFilter(value || undefined);
  }, 200);

  return (
    <div className="field">
      <label className="label">Search : </label>
      <input
        value={value || ""}
        onChange={(e) => {
          setValue(e.target.value);
          onChange(e.target.value);
        }}
        placeholder=" Enter text "
        className="input"
        style={{
          fontSize: "1.1rem",
          margin: "15px",
          display: "inline",
          width: "200px"
        }}
      />
    </div>
  );
}

// Component for Default Column Filter
export const DefaultFilterForColumn = ({
  column: {
    filterValue,
    preFilteredRows: { length },
    setFilter,
  },
}) => {
  return (
    <input className="input"
      value={filterValue || ""}
      onChange={(e) => {
        // Set undefined to remove the filter entirely
        setFilter(e.target.value || undefined);
      }}
      placeholder={`Search ${length} records..`}
      style={{ marginTop: "10px", width: '150px', borderRadius: '2' }}

    />
  );
}

// Component for Custom Select Filter
export const SelectColumnFilter = ({
  column: { filterValue, setFilter, preFilteredRows, id },
}) => {

  // Use preFilteredRows to calculate the options
  const options = useMemo(() => {
    // eslint-disable-next-line @typescript-eslint/no-shadow
    const options = new Set();
    preFilteredRows.forEach((row) => {
      options.add(row.values[id]);
    });
    return [...options.values()];
  }, [id, preFilteredRows]);

  // UI for Multi-Select box
  return (
    <select className="select"
      value={filterValue}
      onChange={(e) => {
        setFilter(e.target.value || undefined);
      }}
    >
      <option value="">All</option>
      {options.map((option, i) => (
        // eslint-disable-next-line react/no-array-index-key
        <option key={i} value={option}>
          {option}
        </option>
      ))}
    </select>
  );
}
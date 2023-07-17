// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable react/button-has-type */
// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable @typescript-eslint/no-unused-vars */
// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable @typescript-eslint/no-use-before-define */
// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable @typescript-eslint/no-shadow */
import React from 'react'
import { useTable, useFilters, useGlobalFilter } from "react-table";
import { usePagination, useRowSelect, useSortBy } from "react-table/dist/react-table.development";
import { Stack } from '@mui/material';
import Card, { CardActions, CardBody, CardFooter, CardHeader, CardLabel, CardTitle } from './bootstrap/Card'
import Button from './bootstrap/Button'
import {
    DefaultFilterForColumn
} from "./Filter";
import ButtonCrud from './ButtonCrud';

const NewTable = ({ columns, data, setDataSelect, title, icon, isCrud,
    tambah, edit, hapus, ekspor }) => {

    const {
        getTableProps, // table props from react-table
        getTableBodyProps, // table body props from react-table
        headerGroups, // headerGroups, if your table has groupings
        // state,
        // visibleColumns,
        prepareRow, // Prepare the row (this function needs to be called for each row before getting the row props)
        // setGlobalFilter,
        // preGlobalFilteredRows,
        page,
        canPreviousPage,
        canNextPage,
        pageOptions,
        pageCount,
        gotoPage,
        nextPage,
        previousPage,
        setPageSize,
        selectedFlatRows,
        state: { pageIndex, pageSize,
            // selectedRowIds 
        },
    } = useTable({
        columns,
        data,
        defaultColumn: { Filter: DefaultFilterForColumn },
    }, useFilters, useGlobalFilter, useSortBy, usePagination,
        useRowSelect,
        hooks => {
            hooks.visibleColumns.push(columns => [
                // Let's make a column for selection
                {
                    id: 'selection',
                    // The header can use the table's getToggleAllRowsSelectedProps method
                    // to render a checkbox
                    // eslint-disable-next-line react/no-unstable-nested-components
                    Header: ({ getToggleAllPageRowsSelectedProps }) => (
                        <div>
                            <IndeterminateCheckbox {...getToggleAllPageRowsSelectedProps()} />
                        </div>
                    ),
                    // The cell can use the individual row's getToggleRowSelectedProps method
                    // to the render a checkbox
                    // eslint-disable-next-line react/no-unstable-nested-components
                    Cell: ({ row }) => (
                        <div>
                            <IndeterminateCheckbox {...row.getToggleRowSelectedProps()} />
                        </div>
                    ),
                },
                ...columns,
            ])
        }
    );


    // eslint-disable-next-line react/no-unstable-nested-components
    const IndeterminateCheckbox = React.forwardRef(
        ({ indeterminate, ...rest }, ref) => {
            const defaultRef = React.useRef()
            const resolvedRef = ref || defaultRef

            React.useEffect(() => {
                resolvedRef.current.indeterminate = indeterminate
            }, [resolvedRef, indeterminate])

            return (
                <input type="checkbox" ref={resolvedRef} {...rest} />
            )
        }
    )

    return (
        <div>
            <Card stretch={false} style={{ marginBottom: 0, borderRadius: 3 }}>
                <CardHeader borderSize={1}>
                    <CardLabel icon={icon} iconColor='info'>
                        <CardTitle tag='div' className='h5'>
                            {title}
                        </CardTitle>
                    </CardLabel>
                    <CardActions>
                        <Stack direction="row" spacing={2}>
                            {
                                isCrud ?
                                    <ButtonCrud
                                        tambah={tambah}
                                        edit={edit}
                                        hapus={hapus}
                                    // eslint-disable-next-line react/jsx-no-useless-fragment
                                    /> : <></>

                            }
                            <Button
                                color='info'
                                icon='CloudDownload'
                                onClick={ekspor}
                            >
                                Export
                            </Button>
                        </Stack>

                    </CardActions>
                </CardHeader>
                <CardBody className='table-responsive' isScrollable style={{ height: 400 }}>
                    <table {...getTableProps()} className="table table-modern"  >
                        <thead>
                            {headerGroups.map(headerGroup => (
                                <tr  {...headerGroup.getHeaderGroupProps()}>
                                    {headerGroup.headers.map(column => (
                                        <th {...column.getHeaderProps(column.getSortByToggleProps())}>{column.render("Header")}
                                            <span>
                                                {column.isSorted
                                                    ? column.isSortedDesc
                                                        ? ' 🔽'
                                                        : ' 🔼'
                                                    : ''}
                                            </span>
                                            {/* Rendering Default Column Filter */}
                                            <div>
                                                {column.canFilter ? column.render("Filter")
                                                    : null}
                                            </div>
                                        </th>
                                    ))}
                                </tr>
                            ))}
                        </thead>
                        <tbody {...getTableBodyProps()}
                            style={{ fontSize: '12px' }}>

                            {page.map((row, i) => {
                                prepareRow(row);
                                return (
                                    <tr {...row.getRowProps()}>
                                        {row.cells.map(cell => {
                                            return <td {...cell.getCellProps()}>{cell.render("Cell")}</td>;
                                        })}
                                    </tr>
                                );
                            })}

                            {/* {dataPagination(items, currentPage, perPage).map((row, i) => {
                                prepareRow(row);
                                return (
                                    <tr {...row.getRowProps()}>
                                        {row.cells.map(cell => {
                                            return <td {...cell.getCellProps()}>{cell.render("Cell")}</td>;
                                        })}
                                    </tr>
                                );

                            })} */}

                        </tbody>
                    </table>
                    <pre>
                        <code>
                            {
                                setDataSelect(JSON.stringify(
                                    {
                                        // selectedRowIds: selectedRowIds,
                                        'selectedRows':
                                            selectedFlatRows.map(
                                                d => d.original
                                            ),
                                    },
                                    null,
                                    2
                                )
                                )
                            }
                        </code>
                    </pre>
                </CardBody>
                <CardFooter>
                    <div className="pagination box" style={{ width: "600px" }}>
                        <button className="button is-dark is-small" onClick={() => gotoPage(0)} disabled={!canPreviousPage}>
                            {'<<'}
                        </button>{' '}
                        <button className="button is-dark is-small" onClick={() => previousPage()} disabled={!canPreviousPage}>
                            {'<'}
                        </button>{' '}
                        <button className="button is-dark is-small" onClick={() => nextPage()} disabled={!canNextPage}>
                            {'>'}
                        </button>{' '}
                        <button className="button is-dark is-small" onClick={() => gotoPage(pageCount - 1)} disabled={!canNextPage}>
                            {'>>'}
                        </button>{' '}
                        <span >
                            Page{' '}
                            <strong>
                                {pageIndex + 1} of {pageOptions.length}
                            </strong>{' '}
                        </span>
                        <span >
                            | Go to page:{' '}
                            <input
                                type="number" className="input"
                                defaultValue={pageIndex + 1}
                                onChange={e => {
                                    const page = e.target.value ? Number(e.target.value) - 1 : 0
                                    gotoPage(page)
                                }}
                                style={{ width: '50px' }}
                            />
                        </span>{' '}
                        <select className="select"
                            value={pageSize}
                            onChange={e => {
                                setPageSize(Number(e.target.value))
                            }}
                        >
                            {[5, 10, 20, 30, 40, 50].map(pageSize => (
                                <option key={pageSize} value={pageSize}>
                                    Show {pageSize}
                                </option>
                            ))}
                        </select>
                    </div>
                    {/* <PaginationButtons
                        data={items}
                        label='items'
                        setCurrentPage={setCurrentPage}
                        currentPage={currentPage}
                        perPage={pageSize}
                        setPerPage={setPageSize}
                    /> */}
                </CardFooter>
            </Card>
        </div>
    )
}

export default NewTable
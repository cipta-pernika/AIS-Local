import { Stack } from '@mui/material'
import React from 'react'
import Tooltips from './bootstrap/Tooltips'
import Button from './bootstrap/Button'

const ActionButton = ({ edit, hapus, info, id }) => {
    return (
        <Stack direction="row" spacing={1}>
            <Tooltips title='Edit'>
                <Button
                    icon='Edit'
                    onClick={() => edit(id)}
                />
            </Tooltips>
            <Tooltips title='Delete'>
                <Button
                    icon='Delete'
                    onClick={() => hapus(id)}
                />
            </Tooltips>
            <Tooltips title='View'>
                <Button
                    icon='Info'
                    onClick={() => info(id)}
                />
            </Tooltips>
        </Stack>
    )
}

export default ActionButton
import React from 'react'
import { Stack } from '@mui/material'
import Button from './bootstrap/Button'

const ButtonCrud = ({ tambah, hapus }) => {
    return (
        <div>
            <Stack direction='row' spacing={2}>
                <Button
                    color='success'
                    icon='Add'
                    onClick={() => tambah()}
                >
                    Add New
                </Button>
                <Button
                    color='danger'
                    icon='Delete'
                    onClick={() => hapus()}
                >
                    Delete
                </Button>

            </Stack>
        </div>
    )
}

export default ButtonCrud
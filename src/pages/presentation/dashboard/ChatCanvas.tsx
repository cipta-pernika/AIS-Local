import React, { FC } from 'react'
import { Button } from '@mui/material';
import OffCanvas, { OffCanvasBody, OffCanvasHeader } from '../../../components/bootstrap/OffCanvas';
import Chat, { ChatGroup, ChatHeader } from '../../../components/Chat';
import InputGroup from '../../../components/bootstrap/forms/InputGroup';
import Textarea from '../../../components/bootstrap/forms/Textarea';
import USERS from '../../../common/data/userDummyData';
import CHATS from '../../../common/data/chatDummyData';

interface IChatProps {
    isReportBox: boolean;
    setIsReportBox: any;
}
const ChatCanvas: FC<IChatProps> = ({
    isReportBox, setIsReportBox
}) => {
    return (
        <OffCanvas
            id='chat'
            isOpen={isReportBox}
            setOpen={setIsReportBox}
            placement='end'
            isModalStyle
            isBackdrop={false}
            isBodyScroll
        // className='offcanvas-size-md'
        >
            <OffCanvasHeader setOpen={setIsReportBox} className='fs-5'
                style={{
                    backgroundColor: '#F64A00',
                    borderTopLeftRadius: 20,
                    borderTopRightRadius: 20,
                }}
            >
                <ChatHeader to={USERS.CHLOE.name} />
            </OffCanvasHeader>
            <OffCanvasBody
                style={{ backgroundColor: '#D2D7BA' }}
            >
                <Chat>
                    {CHATS.CHLOE_VS_JOHN.map((msg) => (
                        <ChatGroup
                            key={msg.id}
                            messages={msg.messages}
                            user={msg.user}
                            isReply={msg.isReply}
                        />
                    ))}
                </Chat>
            </OffCanvasBody>
            <div className='chat-send-message p-3'
                style={{
                    backgroundColor: '#F64A00',
                    borderBottomLeftRadius: 20,
                    borderBottomRightRadius: 20,
                }}
            >
                <InputGroup>
                    <Textarea />
                    <Button variant='contained' style={{ backgroundColor: '#CBCDBF', color: 'black' }}>
                        SEND
                    </Button>
                </InputGroup>
            </div>
        </OffCanvas>
    )
}

export default ChatCanvas
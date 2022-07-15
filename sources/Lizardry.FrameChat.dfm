object FrameChat: TFrameChat
  Left = 0
  Top = 0
  Width = 423
  Height = 455
  TabOrder = 0
  object Panel1: TPanel
    Left = 0
    Top = 423
    Width = 423
    Height = 32
    Align = alBottom
    TabOrder = 0
    object edChatMsg: TEdit
      Left = 1
      Top = 1
      Width = 421
      Height = 30
      Align = alClient
      AutoSize = False
      Color = clBtnFace
      MaxLength = 250
      TabOrder = 0
      OnKeyDown = edChatMsgKeyDown
      ExplicitLeft = 0
      ExplicitTop = 5
    end
  end
  object Panel2: TPanel
    Left = 0
    Top = 0
    Width = 423
    Height = 423
    Align = alClient
    TabOrder = 1
    object RichEdit1: TRichEdit
      Left = 1
      Top = 1
      Width = 421
      Height = 421
      Align = alClient
      Color = clBtnFace
      Font.Charset = RUSSIAN_CHARSET
      Font.Color = clWindowText
      Font.Height = -19
      Font.Name = 'Courier New'
      Font.Style = []
      ParentFont = False
      ReadOnly = True
      ScrollBars = ssVertical
      TabOrder = 0
      Zoom = 100
    end
  end
end

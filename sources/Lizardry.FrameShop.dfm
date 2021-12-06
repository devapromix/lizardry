object FrameShop: TFrameShop
  Left = 0
  Top = 0
  Width = 910
  Height = 604
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object SG: TStringGrid
    Left = 0
    Top = 64
    Width = 910
    Height = 190
    Align = alTop
    Color = clBtnFace
    RowCount = 7
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goRowSelect]
    TabOrder = 0
    OnClick = SGClick
    OnDblClick = SGDblClick
    OnKeyDown = SGKeyDown
  end
  object Panel1: TPanel
    Left = 0
    Top = 0
    Width = 910
    Height = 64
    Align = alTop
    BevelOuter = bvNone
    TabOrder = 1
    object Label1: TLabel
      Left = 0
      Top = 0
      Width = 910
      Height = 64
      Align = alClient
      AutoSize = False
      WordWrap = True
      ExplicitLeft = 160
      ExplicitTop = 32
      ExplicitWidth = 66
      ExplicitHeight = 21
    end
  end
  object Panel2: TPanel
    Left = 0
    Top = 254
    Width = 910
    Height = 64
    Align = alTop
    TabOrder = 2
    object ttInfo: TLabel
      Left = 1
      Top = 1
      Width = 908
      Height = 62
      Align = alClient
      Alignment = taCenter
      AutoSize = False
      WordWrap = True
      ExplicitLeft = 0
      ExplicitTop = 6
      ExplicitWidth = 517
    end
  end
end

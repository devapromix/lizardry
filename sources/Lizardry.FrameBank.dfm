object FrameBank: TFrameBank
  Left = 0
  Top = 0
  Width = 654
  Height = 120
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object Label1: TLabel
    Left = 152
    Top = 19
    Width = 99
    Height = 21
    Caption = #1047#1086#1083#1086#1090#1086': 0'
  end
  object Edit1: TEdit
    Left = 16
    Top = 16
    Width = 121
    Height = 29
    TabOrder = 0
    Text = '0'
    OnKeyPress = Edit1KeyPress
  end
  object bbDeposit: TBitBtn
    Left = 16
    Top = 59
    Width = 121
    Height = 33
    Caption = #1055#1086#1083#1086#1078#1080#1090#1100
    TabOrder = 1
    OnClick = bbDepositClick
  end
  object bbWithdraw: TBitBtn
    Left = 152
    Top = 59
    Width = 113
    Height = 33
    Caption = #1047#1072#1073#1088#1072#1090#1100
    TabOrder = 2
    OnClick = bbWithdrawClick
  end
end

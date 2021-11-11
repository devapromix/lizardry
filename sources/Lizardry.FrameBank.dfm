object FrameBank: TFrameBank
  Left = 0
  Top = 0
  Width = 654
  Height = 169
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object Label1: TLabel
    Left = 166
    Top = 19
    Width = 99
    Height = 21
    Caption = #1047#1086#1083#1086#1090#1086': 0'
  end
  object SpeedButton1: TSpeedButton
    Left = 166
    Top = 59
    Width = 75
    Height = 22
    Caption = '+10'
    OnClick = SpeedButton1Click
  end
  object SpeedButton2: TSpeedButton
    Left = 245
    Top = 59
    Width = 25
    Height = 22
    Caption = '-'
    OnClick = SpeedButton2Click
  end
  object SpeedButton3: TSpeedButton
    Left = 166
    Top = 87
    Width = 75
    Height = 22
    Caption = '+100'
    OnClick = SpeedButton3Click
  end
  object SpeedButton4: TSpeedButton
    Left = 245
    Top = 87
    Width = 25
    Height = 22
    Caption = '-'
    OnClick = SpeedButton4Click
  end
  object SpeedButton5: TSpeedButton
    Left = 166
    Top = 115
    Width = 75
    Height = 22
    Caption = '+1000'
    OnClick = SpeedButton5Click
  end
  object SpeedButton6: TSpeedButton
    Left = 247
    Top = 115
    Width = 25
    Height = 22
    Caption = '-'
    OnClick = SpeedButton6Click
  end
  object bbMyGold: TSpeedButton
    Left = 195
    Top = 143
    Width = 75
    Height = 22
    OnClick = bbMyGoldClick
  end
  object SpeedButton7: TSpeedButton
    Left = 166
    Top = 143
    Width = 23
    Height = 22
    Caption = 'X'
    OnClick = SpeedButton7Click
  end
  object GoldEdit: TEdit
    Left = 16
    Top = 16
    Width = 121
    Height = 29
    TabOrder = 0
    Text = '0'
    OnKeyPress = GoldEditKeyPress
  end
  object bbDeposit: TBitBtn
    Left = 16
    Top = 59
    Width = 137
    Height = 33
    Caption = #1055#1086#1083#1086#1078#1080#1090#1100
    TabOrder = 1
    OnClick = bbDepositClick
  end
  object bbWithdraw: TBitBtn
    Left = 16
    Top = 104
    Width = 137
    Height = 33
    Caption = #1047#1072#1073#1088#1072#1090#1100
    TabOrder = 2
    OnClick = bbWithdrawClick
  end
  object UpDown1: TUpDown
    Left = 137
    Top = 16
    Width = 16
    Height = 29
    Associate = GoldEdit
    Max = 1000000
    TabOrder = 3
  end
end
